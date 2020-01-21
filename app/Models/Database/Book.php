<?php

namespace App\Models\Database;

use App\Models\DynamicProperty;

class BookProp extends DynamicProperty
{
	public $id;

	public $title;

	public $ISBN;

	public $edition;

	public $img_url;

	public $publisher_id;
	public $publisher_name;

	public $price;

	public $release_date;

	public $categories;
	public $categoriesStr;

	public $authors;
	public $authorsStr;

	public function __construct(array $inputArr = null)
	{
		if (empty($inputArr)) return $this;

		// 連想配列をBookオブジェクトに変換する
		foreach ($inputArr as $key => $val) {
			$this->$key = $val;
		}
		return $this;
	}

	public function getColumnNames(): array
	{
		$result = [];
		foreach ($this as $key => $val) {
			$result[] = $key;
		}
		return $result;
	}

	public function authorsToString()
	{
		$result = [];
		foreach ($this->authors as $authorObj) {
			$result[] = $authorObj->name;
		}
		return implode(", ", $result);
	}

	public function categoriesToString()
	{
		$result = [];
		foreach ($this->categories as $categoryObj) {
			$result[] = $categoryObj->name;
		}
		return implode(", ", $result);
	}
}
