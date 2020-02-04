<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
	protected $table = 'favorites';

	public $timestamps = true;	// created_at, updated_at有

	protected $fillable = ['timeline_id', 'user_id', 'status'];

	public function timeline()
	{
		// 多対1
		return $this->belongsTo(
			'App\Models\Eloquent\Timeline'	// 親テーブルモデル
			, 'timeline_id'					// 参照元の外部キー
			, 'id'							// 参照先の主キー
		);
	}

	public function users()
	{
		// 多対1
		return $this->belongsTo(
			'App\Models\Eloquent\User'	// 親テーブルモデル
			, 'user_id'					// 参照元の外部キー
			, 'id'						// 参照先の主キー
		);
	}
}
