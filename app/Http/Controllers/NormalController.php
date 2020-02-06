<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PurchaseService;
use App\Services\RentalService;

class NormalController extends Controller
{
	private $purchase;
	private $rental;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	function __construct(PurchaseService $purchase, RentalService $rental)
	{
		$this->purchase = $purchase;
		$this->rental = $rental;
	}

	/**
	 * 一般TOP画面表示処理
	 */
	public function goTop(Request $request)
	{
		$session = $request->session()->all();

		// 貸出中 - rentalsリスト取得
		$rentals = $this->rental->getRentals($session['id']);
		$rentalsCount = $this->rental->rentalsCount($session['id']);

		// 所持済みのリスト取得
		$purchases = $this->purchase->getPurchases();

		return view('normal.top', compact('rentals', 'rentalsCount', 'purchases'));
	}

}
