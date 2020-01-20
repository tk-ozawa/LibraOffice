<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'orders';

	public $timestamps = true;

	protected $fillable = ['name', 'request_user_id', 'approval_user_id', 'book_id', 'office_id'];

	public function books()
	{
		// 多対1
		return $this->belongsTo(
			'App\Models\Eloquent\Book'		// 参照先テーブルモデル
			, 'book_id'
			, 'id'
		);
	}

	public function offices()
	{
		// 1対1
		return $this->hasOne(
			'App\Models\Eloquent\Office'
			, 'office_id'
			, 'id'
		);
	}

	public function requestUsers()
	{
		// 多対1
		return $this->belongsTo(
			'App\Models\Eloquent\User'		// 親テーブルモデル
			, 'request_user_id'				// 参照元の外部キー
			, 'id'							// 参照先の主キー
		);
	}

	public function approvalUsers()
	{
		// 多対1
		return $this->belongsTo(
			'App\Models\Eloquent\User'		// 親テーブルモデル
			, 'approval_user_id'			// 参照元の外部キー
			, 'id'							// 参照先の主キー
		);
	}
}
