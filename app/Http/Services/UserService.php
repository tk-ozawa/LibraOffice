<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\User;
use App\Models\Database\UserProp;

class UserService
{
	function __construct()
	{
		$this->user = new User();
	}

	/**
	 * ユーザー登録(追加)
	 *
	 * @param UserProp $userProp
	 * @return User
	 */
	public function add(UserProp $userProp)
	{
		$input = UserProp::objToArr($userProp);
		$input['status'] = 0;	// 初期は無効アカウント
		$input['password'] = md5($userProp->password);

		$user = $this->user->create($input);
		return $this->user->where('id', $user->id)->first();
	}

	/**
	 * メールアドレスによるユーザー情報取得
	 *
	 * @param string $email
	 * @return User
	 */
	public function findByEmail(string $email): User
	{
		return $this->user->where('email', $email)->first();
	}

	/**
	 * IDによるユーザー情報取得
	 *
	 * @param int $userId
	 * @return User
	 */
	public function findById(int $userId): User
	{
		return $this->user->where('id', $userId)->first();
	}


	/**
	 * ログインチェック
	 *
	 * @param string $loginEmail
	 * @param string $loginPw
	 * @return string|null
	 */
	public function loginCheck(string $loginEmail, string $loginPw)
	{
		// loginEmailが存在するかチェック
		$registeredRecord = $this->user
			->where('email', $loginEmail)
			->where('status', 1);

		if (!$registeredRecord->exists()) {	// 未登録
			return 'アカウントが存在しません。';
		}

		// 登録済み
		$loginableRecord = $this->user
			->where('id', $registeredRecord->first()->id)
			->where('password', md5($loginPw));

		if (!$loginableRecord->exists()) {	// ログイン失敗
			return 'ログインに失敗しました。';
		}

		return null;	// ログイン成功
	}
}
