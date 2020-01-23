<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\Rental;
use App\Models\Eloquent\Purchase;

class RentalService
{
	private $rental;
	private $purchase;

	function __construct(Rental $rental, Purchase $purchase)
	{
		$this->rental = $rental;
		$this->purchase = $purchase;
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
