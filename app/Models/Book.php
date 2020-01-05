<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $table = 'books';

	public $timestamps = false;

	protected $fillable = ['title', 'ISBN', 'edition', 'img_url', 'publisher_id', 'price', 'release_date'];

	public function publishers()
	{
		// 多対1
		return $this->belongsTo(
			'App\Models\Publisher'			// 親テーブルモデル
			, 'publisher_id'				// 参照元の外部キー
			, 'id'							// 参照先の主キー
		);
	}

	public function orders()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Order'				// 子テーブルモデル
			, 'book_id'						// 参照先の外部キー
			, 'id'							// 参照元の主キー
		);
	}

	public function purchases()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Purchase'			// 子テーブルモデル
			, 'book_id'						// 参照先の外部キー
			, 'id'							// 参照元の主キー
		);
	}

	public function rentals()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Rental'				// 子テーブルモデル
			, 'book_id'						// 参照先の外部キー
			, 'id'							// 参照元の主キー
		);
	}

	public function categories()
	{
		// 多対多
		return $this->belongsToMany(
			'App\Models\Category'		// 参照先テーブルモデル
			, 'book_category_relationships'	// 中間テーブルのテーブル名
			, 'book_id'						// 中間テーブルの参照元外部キー
			, 'category_id'					// 中間テーブルの参照先外部キー
			, 'id'							// 参照元の主キー
			, 'id'							// 参照先の主キー
		);
	}

	public function authors()
	{
		// 多対多
		return $this->belongsToMany(
			'App\Models\Author'				// 参照先テーブルモデル
			, 'book_author_relationships'		// 中間テーブルのテーブル名
			, 'book_id'						// 中間テーブルの参照元外部キー
			, 'author_id'					// 中間テーブルの参照先外部キー
			, 'id'							// 参照元の主キー
			, 'id'							// 参照先の主キー
		);
	}
}
