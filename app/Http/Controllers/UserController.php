<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\BookService;
use App\Models\Database\UserProp;

class UserController extends Controller
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
	 * ユーザーログイン画面表示処理
	 */
	public function goLogin(Request $request)
	{
		return  view('user.login');
	}

	/**
	 * ユーザーログイン処理
	 */
	public function login(Request $request)
	{
		$input = $request->all();

		$loginEmail = $input['email'];
		$loginPw = $input['password'];

		$valiMsg = '';

		// バリデーションエラー
		if (($valiMsg = $this->user->loginCheck($loginEmail, $loginPw)) !== null) {
			dd($valiMsg);
			// return redirect('/user')->with('valiMsg', $valiMsg);
		}

		// セッション付与
		$loginUser = $this->user->findByEmail($loginEmail);
		$session = $request->session();
		$session->put('id', $loginUser->id);
		$session->put('email', $loginEmail);
		$session->put('office_id', $loginUser->office_id);
		$session->put('auth', $loginUser->auth);

		// TOPページ遷移
		return redirect(route('top'))->with('flashMsg', 'ログインしました。');
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
	 * TOP画面表示処理
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


		dd($request->session()->all());


		return view('top');
	}
}
