<?php

namespace App\Models\Database;

class UserProp
{

	public $name;

	public $email;

	public $password;

	public $office_id;

	public $auth;

	public $profile;

	public $birthday;

	public $status;

	public function __construct(array $inputArr = null)
	{
		if (empty($inputArr)) return $this;

		// 連想配列をUserオブジェクトに変換する
		foreach ($inputArr as $key => $val) {
			$this->$key = $val;
		}
		return $this;
	}

	/**
	 * 全カラム名を取得する
	 *
	 * @return array $result
	 */
	public function getColumnNames(): array
	{
		$result = [];
		foreach ($this as $key => $val) {
			$result[] = $key;
		}
		return $result;
	}

	/**
	 * オブジェクトを連想配列に変換
	 *
	 * @param UserProp
	 */
	public static function objToArr(UserProp $userProp)
	{
		$result = [];
		foreach ($userProp as $key => $val) {
			$result[$key] = $val;
		}
		return $result;
	}
}
