<?php

namespace App\Models;

class DynamicProperty
{
	// private $props = [];

	// public function __set($name, $value)
	// {
	// 	$this->props[$name] = $value;
	// }

	// public function __get($name)
	// {
	// 	if(isset($this->props[$name])) {
	// 		return $this->props[$name];
	// 	} else {
	// 		return null;
	// 	}
	// }

	public function getColumnNames(): array
	{
		$result = [];
		foreach ($this as $key => $val) {
			$result[] = $key;
		}
		return $result;
	}
}
