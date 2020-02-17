<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\OrderService;
use App\Services\PurchaseService;
use App\Services\RentalService;
use App\Models\Database\UserProp;

class MasterController extends Controller
{
	private $user;
	private $order;
	private $purchase;
	private $rental;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	function __construct(UserService $user, OrderService $order, PurchaseService $purchase, RentalService $rental)
	{
		$this->user = $user;
		$this->order = $order;
		$this->purchase = $purchase;
		$this->rental = $rental;
	}

	/**
	 * ユーザー登録画面表示処理
	 */
	public function goRegister(Request $request)
	{
		return view('user.add');
	}

	/**
	 * ユーザー登録処理
	 */
	public function register(Request $request)
	{
		$input = $request->all();
		$session = $request->session()->all();

		$userProp = new UserProp($input);
		$userProp->office_id = $session['office_id'];	// 登録者と同じオフィス
		$userProp->password = substr(bin2hex(random_bytes(7)), 0, 7);	// イイカンジのパスワード文字列

		$password = $userProp->password;

		// メールでパスワードを知らせる

		// 大阪就プレでは登録完了ページで伝える

		$user = $this->user->add($userProp);

		return view('user.add_complete', compact('user', 'password'));
	}


	/**
	 * 管理者TOP画面表示処理
	 */
	public function goTop(Request $request)
	{
		$session = $request->session()->all();

		// 貸出中 - rentalsリスト取得
		$rentals = $this->rental->getRentals($session['id']);
		$rentalsCount = $this->rental->rentalsCount($session['id']);

		// 注文依頼 - ordersリスト取得
		$requests = $this->order->getRequests();
		$requestsCount = $this->order->requestsCount();

		// 社内図書 - purchasesリスト取得
		// 発注中のリスト取得
		$orderings = $this->purchase->getOrderings();
		$orderingsCount = $this->purchase->orderingsCount();

		// 所持済みのリスト取得
		$purchases = $this->purchase->getPurchases();

		$ranking = $this->rental->rentalRanking();

		return view('master.top', compact('rentals', 'rentalsCount', 'requests', 'requestsCount', 'orderings', 'purchases', 'orderingsCount', 'ranking'));
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
