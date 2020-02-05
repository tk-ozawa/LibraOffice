<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
	protected $table = 'timeline';

	public $timestamps = true;	// created_at, updated_at有

	protected $fillable = ['content', 'user_id', 'purchase_id'];

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

	public function reactions()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\Reaction'	// 子テーブルのモデル
			, 'timeline_id'					// 参照先の外部キー
			, 'id'							// 参照元の主キー
		);
	}
}
