<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\Timeline;

class TimelineService
{
	function __construct()
	{
		$this->timeline = new Timeline();
	}

	/**
	 * タイムライン発行
	 *
	 * @param string $content
	 * @param int $userId
	 * @param int $purchaseId
	 * @return
	 */
	public function insert(string $content, int $userId, int $purchaseId)
	{
		$this->timeline->create([
			'content' => $content,
			'user_id' => $userId,
			'purchase_id' => $purchaseId
		]);
	}

	/**
	 * タイムライン取得
	 */
	public function getAll()
	{
		return $this->timeline
			->with(['users' => function ($q) {
				$q->select('users.id', 'users.name');
			}])
			->with(['purchases' => function ($q) {
				$q->select('purchases.id', 'purchases.book_id')
					->with(['books' => function ($q) {
						$q->select('books.id', 'books.title');
					}]);
			}])
			->orderBy('timeline.created_at', 'DESC')
			->paginate(15);
	}
}
