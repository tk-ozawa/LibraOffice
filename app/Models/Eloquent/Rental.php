<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
	protected $table = 'rentals';

	public $timestamps = true;	// created_at, updated_at有

	protected $fillable = ['purchase_id', 'user_id', 'status'];

	public function purchases()
	{
		// 多対1
		return $this->belongsTo(
			'App\Models\Eloquent\Purchase'			// 親テーブルモデル
			, 'purchase_id'					// 参照元の外部キー
			, 'id'							// 参照先の主キー
		);
	}

	public function users()	// 要確認:リレーション関係の正確性
	{
		// 多対1
		return $this->belongsTo(
			'App\Models\Eloquent\User'				// 親テーブルモデル
			, 'user_id'						// 参照元の外部キー
			, 'id'							// 参照先の主キー
		);
	}
}
