<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\Book;
use App\Models\Eloquent\Category;
use App\Models\Eloquent\Publisher;
use App\Models\Eloquent\Author;

class CategoryService
{
	function __construct()
	{
		$this->book = new Book();
		$this->category = new Category();
		$this->publisher = new Publisher();
		$this->author = new Author();
		$this->dateTime = new \DateTime();
	}

	/**
	 * カテゴリ情報登録
	 *
	 * @param array $categories
	 * @return array $regCategories
	 */
	function firstOrCreate(array $categories)
	{
		$regCategories = [];
		foreach ($categories as $category) {
			$result = $this->category->firstOrCreate(['name' => $category]);
			$regCategories[] = json_decode(json_encode($result), true)['id'];
		}
		return $regCategories;
	}

	/**
	 * 書籍IDから著者情報を取得
	 *
	 * @param int $bookId
	 * @return array
	 */
	public function getByBookId(int $bookId)
	{
		$query = $this->book
			->where('id', $bookId)
			->with(["categories" => function ($q) {
				$q->select('categories.id', 'categories.name');
			}]);

		return $query->first()->categories;
	}
}
