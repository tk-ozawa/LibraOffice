<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';

	public $timestamps = false;

	protected $fillable = ['name'];

	public function books()
	{
		// 多対多
		return $this->belongsToMany(
			'App\Models\Eloquent\Book'		// 参照先テーブルモデル
			, 'book_category_relationships' // 中間テーブルのテーブル名
			, 'category_id'                 // 中間テーブルの参照元外部キー
			, 'book_id'                     // 中間テーブルの参照先外部キー
			, 'id'                          // 参照元の主キー
			, 'id'                          // 参照先の主キー
		);
	}
}
