<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\Publisher;

class PublisherService
{
	function __construct()
	{
		$this->publisher = new Publisher();
	}

	/**
	 * 出版社情報登録
	 *
	 * @param string $pubName
	 */
	function firstOrCreate($pubName)
	{
		return $this->publisher->firstOrCreate(['name' => $pubName]);
	}

	/**
	 * IDによる出版社情報取得
	 *
	 * @param int $pubId
	 * @return
	 */
	public function findById(int $pubId)
	{
		return $this->publisher->where('id', $pubId)->first();
	}
}
