<?php
namespace App\Services;

use App\Models\Eloquent\Office;
use App\Services\UserService;
use App\Models\Database\UserProp;

class OfficeService
{
	private $office;
	private $userService;

	function __construct(Office $office, UserService $userService)
	{
		$this->office = $office;
		$this->userService = $userService;
	}

	/**
	 * オフィス一覧取得
	 *
	 * @return array
	 */
	public function getList()
	{
		return $this->office->get();
	}

	/**
	 * オフィスアカウント(ユーザーアカウント)登録処理
	 *
	 * @param array $input
	 * @return User
	 */
	public function create(array $input)
	{
		$office = $this->office
			->create(['name' => $input['office_name']]);

		$input['office_id'] = $office->id;
		$input['auth'] = 0;

		return $this->userService->add(new UserProp($input));
	}
}
