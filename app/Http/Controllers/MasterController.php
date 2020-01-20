<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\BookService;
use App\Models\Database\UserProp;

class MasterController extends Controller
{
	private $user;
	private $book;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	function __construct(UserService $user, BookService $book)
	{
		$this->user = $user;
		$this->book = $book;
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

		// 社内図書 - purchasesリスト取得


		return view('master.top');
	}

}
