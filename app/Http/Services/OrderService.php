<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\Order;
use App\Models\Eloquent\Book;
use App\Models\Eloquent\Publisher;
use App\Models\Database\BookProp;

class OrderService
{
	function __construct()
	{
		$this->book = new Book();
		$this->publisher = new Publisher();
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

	/**
	 * 未承諾な注文一覧を取得
	 *
	 * @return array
	 */
	public function getRequests(): array
	{
		$reuqests = $this->order->whereNull('approval_user_id')->get();

		$reqProps = [];
		foreach ($reuqests as $req) {
			$bookDB = $this->book
				->where('id', $req->book_id)
				->with(['authors' => function ($q) {
					$q->select('authors.id', 'authors.name');
				}])
				->with(['categories' => function ($q) {
					$q->select('categories.id', 'categories.name');
				}])
				->first();

			$orderDB = $this->order
				->where('book_id', $req->book_id)
				->with(['requestUsers' => function ($q) {
					$q->select('users.id', 'users.name');
				}])
				->first();

			$bookProp = new BookProp($bookDB->toArray());
			$bookProp->publisher_name = $this->publisher->where('id', $bookDB->publisher_id)->first()->name;
			$reqProps[] = ['book' => $bookProp, 'order' => $orderDB];
		}

		return $reqProps;
	}
}
