<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\Purchase;
use App\Models\Eloquent\Order;
use App\Models\Eloquent\Book;
use App\Models\Eloquent\Publisher;
use App\Models\Database\BookProp;

class PurchaseService
{
	function __construct()
	{
		$this->book = new Book();
		$this->publisher = new Publisher();
		$this->purchase = new Purchase();
		$this->order = new Order();
	}

	/**
	 * 社内図書情報登録(依頼承諾&発注)
	 *
	 * @param int $orderId
	 * @param int $approvalUserId
	 */
	public function orderAccept(int $orderId,int $approvalUserId)
	{
		// 注文依頼に承諾者情報を追加
		$order = $this->order->where('id', $orderId)->first();
		$order->approval_user_id = $approvalUserId;
		$order->save();

		// 購入情報を登録
		$purchase = $this->purchase->create([
			'book_id' => $order->book_id,
			'user_id' => $approvalUserId,
			'office_id' => $order->office_id,
			'purchase_date' => \Carbon::now(),
			'status' => 0,	// 未所持
		]);

		return $this->purchase->where('id', $purchase->id)->first();
	}

	/**
	 * 社内図書情報更新(書籍到着)
	 */
	public function orderComplete()
	{

	}

	/**
	 * 発注中の書籍一覧を取得
	 *
	 * @return array
	 */
	public function getAccepts(): array
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
