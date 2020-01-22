<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\BookService;
use App\Services\OrderService;
use App\Services\PurchaseService;
use App\Models\Database\UserProp;

class MasterController extends Controller
{
	private $user;
	private $book;
	private $order;
	private $purchase;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	function __construct(UserService $user, BookService $book, OrderService $order, PurchaseService $purchase)
	{
		$this->user = $user;
		$this->book = $book;
		$this->order = $order;
		$this->purchase = $purchase;
	}

	/**
	 * ユーザー登録画面表示処理
	 */
	public function goRegister(Request $request)
	{
		return view('master.add');
	}

	/**
	 * ユーザー登録処理
	 */
	public function register(Request $request)
	{
		$input = $request->all();

		// ダミーデータ
		$session = [
			'office_id' => 1,
			'user_id' => 1,
			'auth' => 0
		];

		$userProp = new UserProp($input);
		$userProp->office_id = $session['office_id'];	// 登録者と同じオフィス
		$userProp->password = substr(bin2hex(random_bytes(7)), 0, 7);	// メールで知らせる

		$newUser = $this->user->add($userProp);

		// メール送信

		dd($userProp);
		// topに戻ってflashMsg
	}


	/**
	 * 管理者TOP画面表示処理
	 */
	public function goTop(Request $request)
	{
		/*
			"email" => "test@test.com"
			"id" => 2
			"auth" => 0
			"flashMsg" => "ログインしました。"
			"office_id" => 1
		 */


		// dd($request->session()->all());

		// 注文依頼 - ordersリスト取得
		$requests = $this->order->getRequests();


		// 社内図書 - purchasesリスト取得
		// 発注中のリスト取得
		$orderings = $this->purchase->getOrderings();

		// 所持済みのリスト取得
		$purchases = $this->purchase->getPurchases();

		return view('master.top', compact('requests', 'orderings', 'purchases'));
	}

	/**
	 * 注文依頼承諾画面表示処理
	 */
	public function goOrderAccept(Request $request, int $orderId)
	{
		$order = $this->order->findById($orderId);
		$book = $order->books;
		$user = $order->requestUsers;

		return view('master.orderAccept', compact('order', 'book', 'user'));
	}

	/**
	 * 注文依頼承諾&書籍発注処理
	 */
	public function orderAccept(Request $request)
	{
		$input = $request->all();
		$session = $request->session()->all();

		$purchase = $this->purchase->createPurchase($input['order_id'], $session['id']);

		return redirect(route('master.top'))->with("flashMsg", "発注処理を行いしました。発注ID:{$purchase->id}");
	}

	/**
	 * 書籍発注完了申請画面表示処理
	 */
	public function goPurchaseComplete(Request $request, int $purchaseId)
	{
		$purchase = $this->purchase->findById($purchaseId);
		$book = $purchase->books;
		$user = $purchase->users;

		return view('master.purchaseComplete', compact('purchase', 'book', 'user'));
	}

	/**
	 * 書籍発注完了申請処理
	 */
	public function purchaseComplete(Request $request)
	{
		$input = $request->all();

		$purchase = $this->purchase->purchaseComplete($input['purchase_id']);

		return redirect(route('master.top'))->with("flashMsg", "社内図書を登録しました。社内図書ID:{$purchase->id}");
	}
}
