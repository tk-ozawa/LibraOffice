<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\Rental;
use App\Models\Eloquent\User;
use App\Models\Eloquent\Purchase;

class RentalService
{
	private $rental;
	private $purchase;
	private $user;

	function __construct(Rental $rental, Purchase $purchase, User $user)
	{
		$this->rental = $rental;
		$this->purchase = $purchase;
		$this->user = $user;
	}

	/**
	 * 貸出処理
	 *
	 * @param int $purchaseId
	 * @param int $userId
	 * @return Purchase
	 */
	public function apply(int $purchaseId, int $userId): Purchase
	{
		$this->rental->create([
			'purchase_id' => $purchaseId,
			'user_id' => $userId,
			'status' => 0	// 0: 貸出中
		]);

		return $this->purchase
			->where('id', $purchaseId)
			->with(['books' => function ($q) {
				$q->select('books.id', 'books.title');
			}])
			->first();
	}

	/**
	 * 返却処理
	 *
	 * @param int $purchaseId
	 * @param int $userId
	 * @return Purchase
	 */
	public function return(int $purchaseId, int $userId): Purchase
	{
		$return = $this->rental
			->where('purchase_id', $purchaseId)
			->where('user_id', $userId)
			->where('status', 0)
			->first();
		$return->status = 1;
		$return->save();

		return $this->purchase
			->where('id', $purchaseId)
			->with(['books' => function ($q) {
				$q->select('books.id', 'books.title');
			}])
			->first();
	}

	/**
	 * 社内図書IDから借りたことのある全ユーザーと借りた回数を取得する
	 *
	 * @param int $purchaseId
	 * @return array
	 */
	public function getRentaledUsersAndCount(int $purchaseId): array
	{
		$userRentalCounts = $this->rental
			->select(DB::raw('COUNT(*) as count, rentals.user_id'))
			->where('purchase_id', $purchaseId)
			->groupBy('user_id')
			->get();

		$retArr = [];
		foreach ($userRentalCounts as $rental) {
			$user = $this->user->where('id', $rental->user_id)->first();
			$retArr[] = ['count' => $rental->count, 'user' => $user];
		}

		return $retArr;
	}

	/**
	 * 貸出中かどうかチェック+貸出中のユーザーIDを取得
	 *
	 * @param int $purchaseId
	 * @return array
	 */
	public function isRentalUser(int $purchaseId): array
	{
		$isRental = $this->rental
			->where('purchase_id', $purchaseId)
			->where('status', 0)
			->exists();

		$rentalUserId = 0;

		if ($isRental) {
			$rentalUserId = $this->rental
				->where('purchase_id', $purchaseId)
				->where('status', 0)
				->first()->user_id;
		}

		return ['flg' => $isRental, 'userId' => $rentalUserId];
	}

	/**
	 * ユーザーIDから貸出中リストを取得する
	 *
	 * @param int $userId
	 * @return array{Rental}
	 */
	public function getRentals(int $userId)
	{
		$existsRentaling = $this->rental
			->where('user_id', $userId)
			->where('status', 0)
			->exists();

		if (!$existsRentaling) {
			return null;
		}

		return $this->rental
			->where('user_id', $userId)
			->where('status', 0)	// 0:貸出中
			->with(['purchases' => function ($q) {
				$q->select('purchases.id', 'purchases.book_id', 'purchases.purchase_date')
					->with(['books' => function ($q) {
						$q->select('books.id', 'books.title', 'books.price', 'books.ISBN', 'books.edition', 'books.release_date', 'books.img_url', 'books.publisher_id')
							->with(['categories' => function ($q) {
								$q->select('categories.id', 'categories.name');
							}])
							->with(['authors' => function ($q) {
								$q->select('authors.id', 'authors.name');
							}])
							->with(['publishers' => function ($q) {
								$q->select('publishers.id', 'publishers.name');
							}]);
					}]);
			}])
			->get();
	}

	/**
	 * ユーザーIDから貸出中の書籍の件数を取得する
	 *
	 * @param int $userId
	 * @return int
	 */
	public function rentalsCount(int $userId)
	{
		return $this->rental
			->where('user_id', $userId)
			->where('status', 0)	// 貸出中
			->count('id');
	}
}
