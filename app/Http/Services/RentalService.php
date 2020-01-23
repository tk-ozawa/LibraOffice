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
	 * 貸出中かどうかチェック
	 *
	 * @param int $purchaseId
	 * @return bool
	 */
	public function is_rental(int $purchaseId)
	{
		return $this->rental
			->where('purchase_id', $purchaseId)
			->where('status', 0)
			->exists();
	}
}
