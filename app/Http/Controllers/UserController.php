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
		# code...
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
		if ($valiMsg = $this->user->loginCheck($loginEmail, $loginPw) !== null) {
			return redirect('/user')->with('valiMsg', $valiMsg);
		}

		// セッション付与
		// TOPページ遷移
	}

	/**
	 * ユーザー登録画面表示処理
	 */
	public function goRegister(Request $request)
	{

	}

	/**
	 * ユーザー登録処理
	 */
	public function register(Request $request)
	{
		$input = $request->all();

		$input = [
			'name' => 'aaa',
			'email' => 'aaa@aaa.aa',
			'password' => 'hoge',
			'tel' => '1234567890',
		];

		$userProp = new UserProp();
		$usersProp = $userProp->refineByColumn($input);

		// $userColumn = $userProp->getColumnNames();
		// $usersProp = [];
		// foreach ($input as $inputParam) {	// 配列 as obj
		// 	foreach ($userColumn as $column) {	// 配列 as str
		// 		$userProp->$column = $inputParam->$column;
		// 	}
		// 	$usersProp[] = $userProp;
		// }
		dd($usersProp);

	}
}
