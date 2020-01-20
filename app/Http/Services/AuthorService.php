<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Eloquent\Book;
use App\Models\Eloquent\Category;
use App\Models\Eloquent\Publisher;
use App\Models\Eloquent\Author;

class AuthorService
{
	function __construct()
	{
		$this->book = new Book();
		$this->category = new Category();
		$this->publisher = new Publisher();
		$this->author = new Author();
	}

	/**
	 * 著者情報登録
	 *
	 * @param array $authors
	 * @return array $regAuthors
	 */
	function firstOrCreate(array $authors)
	{
		$regAuthors = [];
		foreach ($authors as $author) {
			$result = $this->author->firstOrCreate(['name' => $author]);
			$regAuthors[] = json_decode(json_encode($result), true)['id'];	//	$regAuthors[] = $result->id;
		}
		return $regAuthors;
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
			->with(["authors" => function ($q) {
				$q->select('authors.id', 'authors.name');
			}]);

		return $query->first()->authors;
	}
}
