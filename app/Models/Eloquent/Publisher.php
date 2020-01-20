<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
	protected $table = 'publishers';

	public $timestamps = false;

	protected $fillable = ['name'];

	public function books()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\Book'				// 子テーブルモデル
			, 'publisher_id'				// 参照先の外部キー
			, 'id'							// 参照元の主キー
		);
	}
}
