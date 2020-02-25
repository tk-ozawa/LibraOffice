<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $table = 'users';

	public $timestamps = true;	// created_at, updated_at有

	protected $fillable = ['name', 'email', 'password', 'office_id', 'auth', 'tel', 'birthday', 'url', 'status'];

	public function request_orders()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\Order'		// 子テーブルモデル
			, 'request_user_id'				// 参照先の外部キー
			, 'id'							// 参照元の主キー
		);
	}

	public function approval_orders()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\Order'		// 子テーブルモデル
			, 'approval_user_id'			// 参照先の外部キー
			, 'id'							// 参照元の主キー
		);
	}

	public function purchases()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\Purchase'	// 子テーブルモデル
			, 'user_id'						// 参照先の外部キー
			, 'id'							// 参照元の主キー
		);
	}

	public function rentals()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\Rental'	// 子テーブルのモデル
			, 'user_id'						// 参照先の外部キー
			, 'id'							// 参照元の主キー
		);
	}

	public function reactions()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\Reaction'	// 子テーブルのモデル
			, 'user_id'						// 参照先の外部キー
			, 'id'							// 参照元の主キー
		);
	}

	public function offices()
	{
		// 1対1
		return $this->belongsTo(
			'App\Models\Eloquent\Office'
			, 'office_id'
			, 'id'
		);
	}
}
