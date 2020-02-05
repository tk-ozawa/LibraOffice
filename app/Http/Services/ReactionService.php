<?php
namespace App\Services;

use App\Models\Eloquent\Reaction;

class ReactionService
{
	private $reaction;

	function __construct(Reaction $reaction)
	{
		$this->reaction = $reaction;
	}

	/**
	 * リアクションボタンを押した時の処理
	 *
	 * @param int $timelineId
	 * @param int $userId
	 * @return int
	 */
	public function pushBtn(int $timelineId, int $userId): int
	{
		$reactionQuery = $this->reaction
			->where('timeline_id', $timelineId)
			->where('user_id', $userId);

		// 「リアクションを1度でも押したことがない」でPush
		if (!$reactionQuery->exists()) {
			// リアクション登録
			$this->reaction->create([
				'timeline_id' => $timelineId,
				'user_id' => $userId,
				'status' => 1
			]);
			return 1;
		}

		$reaction = $reactionQuery->first();

		if ($reaction->status === 1) {
			// リアクション解除
			$reaction->status = 0;
			$reaction->save();
			return 0;
		}

		// リアクション登録
		$reaction->status = 1;
		$reaction->save();
		return 1;
	}
}
