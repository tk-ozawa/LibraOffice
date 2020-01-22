<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\Rental;

class RentalService
{
	private $rental;

	function __construct(Rental $rental)
	{
		$this->rental = $rental;
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
