<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\RentalService;
use App\Services\TimelineService;
use App\Models\Database\UserProp;
use App\Models\Eloquent\Rental;

class UserController extends Controller
{
	private $user;
	private $rental;
	private $timelineService;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	function __construct(UserService $user, RentalService $rental, TimelineService $timelineService)
	{
		$this->user = $user;
		$this->rental = $rental;
		$this->timelineService = $timelineService;
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

	/**
	 * ユーザー詳細画面表示処理
	 */
	public function goDetail(Request $request, int $userId)
	{

	}

	/**
	 * マイページ表示
	 */
	public function goMypage(Request $request)
	{
		$session = $request->session()->all();
		$userId = $session['id'];

		// 現在借りている本
		$rentals = $this->rental->getRentals($userId);
		$rentalsCount = $this->rental->rentalsCount($userId);

		// 今までいくら得したか
		$profitMoney = $this->rental->getHistoryProfitByUserId($userId);

		// 借りた履歴
		$rentalsHistory = $this->rental->getHistoryByUserId($userId);

		$loginUser = $this->user->findById($userId);

		return view('user.mypage', compact('rentals', 'rentalsCount', 'rentalsHistory', 'loginUser', 'profitMoney'));
	}

	/**
	 * プロフィール編集処理
	 */
	public function editProfile(Request $request)
	{
		$input = $request->all();

		$this->user->updateProfile($input, $request->session()->get('id'));

		return;
	}

	/**
	 * タイムライン画面表示処理
	 */
	public function goTimeline(Request $request)
	{
		$timeline = $this->timelineService->getAll();

		return view('user.timeline', compact('timeline'));
	}
}
