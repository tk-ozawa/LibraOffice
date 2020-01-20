<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * 購入/所持テーブルモデル
 */
class Purchase extends Model
{
	protected $table = 'purchases';

	public $timestamps = true;	// created_at, updated_at有

	protected $fillabe = ['book_id', 'user_id', 'office_id', 'purchase_date', 'status'];

	public function rentals()
	{
		// 1対多
		return $this->hasMany(
			'App\Models\Eloquent\Rental'		// 子テーブルモデル
			, 'purchase_id'			// 参照先の外部キー
			, 'id'					// 参照元の主キー
		);
	}
}
