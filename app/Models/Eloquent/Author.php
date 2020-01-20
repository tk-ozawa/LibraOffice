<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
	protected $table = 'authors';

	public $timestamps = false;

	protected $fillable = ['name'];

	public function books()
	{
		// 多対多
		return $this->belongsToMany(
			'App\Models\Eloquent\Book'				// 参照先テーブルモデル
			, 'book_author_relationships'		// 中間テーブルのテーブル名
			, 'author_id'					// 中間テーブルの参照元外部キー
			, 'book_id'						// 中間テーブルの参照先外部キー
			, 'id'							// 参照元の主キー
			, 'id'							// 参照先の主キー
		);
	}
}
