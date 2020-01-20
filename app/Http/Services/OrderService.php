<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\Order;

class OrderService
{
	function __construct()
	{
		$this->order = new Order();
	}

	/**
	 * 注文情報登録(依頼)
	 *
	 * @param int $requestUserId
	 * @param int $bookId
	 * @param int $officeId
	 */
	public function createRequest(int $requestUserId, int $bookId, int $officeId)
	{
		return $this->order
			->create([
				'request_user_id' => $requestUserId,
				'book_id' => $bookId,
				'office_id' => $officeId
			]);
	}
}
