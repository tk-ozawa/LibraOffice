<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\User;

class UserService
{
	function __construct()
	{
		$this->user = new User();
	}

	/**
	 * ログインチェック
	 *
	 * @param string $loginEmail
	 * @param string $loginPw
	 * @return int
	 */
	public function loginCheck(string $loginEmail, string $loginPw)
	{
		// loginEmailが存在するかチェック
		$registeredRecord = $this->user
			->where('email', $loginEmail);

		if (!$registeredRecord->exists()) {	// 未登録
			return 'アカウントが存在しません。';
		}

		// 登録済み
		$loginableRecord = $this->user
			->where('id', $registeredRecord->first()->id)
			->where('password', $loginPw);

		if (!$loginableRecord->exists()) {	// ログイン失敗
			return 'ログインに失敗しました。';
		}

		return null;	// ログイン成功
	}
}
