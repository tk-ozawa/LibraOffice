<?php

namespace App\Models\Database;

// use App\Models\DynamicProperty;

class UserProp // extends DynamicProperty
{
	public $name;

	public $email;

	public $password;

	public $office_id;

	public $auth;

	public $tel;

	public $birthday;

	public $url;

	public $status;

	public function getColumnNames(): array
	{
		$result = [];
		foreach ($this as $key => $val) {
			$result[] = $key;
		}
		return $result;
	}

	public function refineByColumn(array $inputArr): array
	{
	}
}
