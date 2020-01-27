<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Models\Database\UserProp;

class UserController extends Controller
{
	private $user;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	function __construct(UserService $user)
	{
		$this->user = $user;
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
			return redirect(route('login.form'))->with('valiMsg', $valiMsg);
		}

		// セッション付与
		$loginUser = $this->user->findByEmail($loginEmail);
		$session = $request->session();
		$session->put('id', $loginUser->id);
		$session->put('email', $loginEmail);
		$session->put('office_id', $loginUser->office_id);
		$session->put('auth', $loginUser->auth);

		// 幹部以上
		if ($loginUser->auth === 0) {
			return redirect(route('master.top'))->with('flashMsg', 'ログインしました。');
		}

		// 一般
		return redirect(route('normal.top'))->with('flashMsg', 'ログインしました。');
	}

	/**
	 * ログアウト処理
	 */
	public function logout(Request $request)
	{
		$request->session()->flush();
		return redirect(route('login.form'))->with('flashMsg', 'ログアウトしました。');
	}
}
