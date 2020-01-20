<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
	protected $table = 'offices';

	public $timestamps = false;

	protected $fillable = ['name'];

	public function orders()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\Order'		// 子テーブルモデル
			, 'office_id'			// 参照先の外部キー
			, 'id'					// 参照元の主キー
		);
	}

	public function purchases()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\Purchase'	// 子テーブルモデル
			, 'office_id'			// 参照先の外部キー
			, 'id'					// 参照元の主キー
		);
	}

	public function users()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\User'		// 子テーブルモデル
			, 'office_id'			// 参照先の外部キー
			, 'id'					// 参照元の主キー
		);
	}
}
