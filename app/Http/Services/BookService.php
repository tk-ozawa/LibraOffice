<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Services\CategoryService;
use App\Services\PublisherService;
use App\Services\AuthorService;
use App\Models\Eloquent\Book;
use App\Models\Database\BookProp;
use App\Models\Database\AuthorProp;
use App\Models\Database\CategoryProp;
use App\Models\Database\PublisherProp;

class BookService
{
	function __construct()
	{
		$this->book = new Book();
		$this->categoryService = new CategoryService();
		$this->publisherService = new PublisherService();
		$this->authorService = new AuthorService();
		$this->dateTime = new \DateTime();
	}

	/**
	 * 本情報を登録する
	 *
	 * @param array $bookAsc
	 */
	public function createOld($bookAsc)
	{
		$addDatas = [];
		foreach ($bookAsc as $key => $val) {
			$addDatas[$key] = $val[$key];
		}

		$data = $this->book->create($addDatas);
		$data = $this->book->find($data->id);
		return $data;
	}

	/**
	 * 本情報を登録する
	 *
	 * @param BookProp $book
	 */
	public function firstOrCreate(BookProp $book)
	{
		return $this->book->firstOrCreate([
			'title' => $book->title,
			'price' => $book->price,
			'publisher_id' => $book->publisher_id,
			'ISBN' => ($book->ISBN) ?? null,
			'edition' => ($book->edition) ?? 1
		], [
			'release_date' => $book->release_date,
			'img_url' => ($book->img_url) ?? null
		]);
	}

	/**
	 * ISBNから本情報を取得
	 *
	 * @param array $bookDatas
	 */
	public function getByISBN(array $bookDatas)
	{
		$bookProp = new BookProp();

		// 本情報がDBに存在するかチェック
		if (!empty($bookDB = $this->findByISBNandEdition($bookDatas['ISBN'], $bookDatas['edition']))) {
			// booksカラム分
			$booksColumn = $bookProp->getColumnNames();
			foreach ($booksColumn as $column) {	// booksのカラムのみ取得
				if ($column === 'categories' || $column === 'authors') continue;	// リレーション分はパス
				$bookProp->$column = $bookDB->$column;
			}

			// categoriesカラム分
			$categoryProp = new CategoryProp();
			$categoriesColumn = $categoryProp->getColumnNames();
			$categoriesProp = [];
			foreach ($bookDB->categories as $categoryDB) {	// 配列 as obj
				foreach ($categoriesColumn as $column) {	// 配列 as str
					$categoryProp->$column = $categoryDB->$column;
				}
				$categoriesProp[] = $categoryProp;
			}
			$bookProp->categories = $categoriesProp;

			// authorsカラム分
			$authorProp = new CategoryProp();
			$authorsColumn = $authorProp->getColumnNames();
			$authorsProp = [];
			foreach ($bookDB->authors as $authorsDB) {	// 配列 as obj
				foreach ($authorsColumn as $column) {	// 配列 as str
					$authorProp->$column = $authorsDB->$column;
				}
				$authorsProp[] = $authorProp;
			}
			$bookProp->authors = $authorsProp;

			return $bookProp;
		}

		// 楽天書籍検索API
		$query = http_build_query([
			"format" => "json",
			"isbn" => $bookDatas['ISBN'],
			"applicationId" => env('RAKUTEN_BOOKS_APP_ID'),
		]);

		$url = "https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404?{$query}";
		$rakutenObj = json_decode(file_get_contents($url));

		if (empty($rakutenObj->Items)) {	// 「マスタリングTCP/IP入門編 第5版」等がRakutenに未登録
			return null;
		}
		$items = $rakutenObj->Items[0]->Item;

		// 出版社を登録and取得
		$publisher = $this->publisherService->firstOrCreate($items->publisherName);
		$bookProp->publisher_id = $publisher->id;
		$bookProp->title = $items->title;
		$bookProp->price = $items->itemPrice;
		$bookProp->img_url = $items->largeImageUrl;

		// 国会図書館API ← 実質的にnullはありえない
		$xml = file_get_contents("http://iss.ndl.go.jp/api/opensearch?isbn={$bookDatas['ISBN']}");
		$xmlObject = simplexml_load_string($xml);
		$catArr = [];
		foreach ($xmlObject->channel->item as $item) {
			$PubByUnixDatetime[] = json_decode(json_encode($item->pubDate), true);
			$subject = json_decode(json_encode($item->children("dc", true)->subject), true);
			foreach ($subject as $param) {
				if (preg_match( "/[ぁ-ん]+|[ァ-ヴー]+/u", $param)) {    // 日本語で記述されているカテゴリのみ取得
					$catArr[] = str_replace(array(" ", "　"), "", $param);  // 「プログラミング(コンピュータ)、プログラミング (コンピュータ)」等の混在を避ける
				}
			}
		}

		// categoriesカラム分
		$categoriesAPI = array_values(array_unique($catArr));
		$categoryProp = new CategoryProp();
		$categoriesColumn = $categoryProp->getColumnNames();
		$categoriesProp = [];
		foreach ($categoriesAPI as $categoryName) {	// 配列 as obj
			$categoryProp = new CategoryProp();
			$categoryProp->name = $categoryName;
			$categoriesProp[] = $categoryProp;
		}
		$bookProp->categories = $categoriesProp;

		// authorsカラム分
		$authorsAPI = explode("/", $items->author);
		$authorProp = new CategoryProp();
		$authorsColumn = $authorProp->getColumnNames();
		$authorsProp = [];
		foreach ($authorsAPI as $authorName) {	// 配列 as obj
			$authorProp = new CategoryProp();
			$authorProp->name = $authorName;
			$authorsProp[] = $authorProp;
		}
		$bookProp->authors = $authorsProp;

		// release_date
		$pubDateArr = [];
		foreach($PubByUnixDatetime as $arr) {
			if (!empty($arr)) $pubDateArr = $arr;
		}
		$pubDate = (!empty($pubDateArr)) ? date("Y-m-d", strtotime($pubDateArr[0])) : null;	// そもそもpubDateが存在しないパターンがある 例)WEB+DB Press
		$bookProp->release_date = $pubDate;	// pubDate表記をY-m-dに変換

		$bookProp->ISBN = $bookDatas['ISBN'];
		$bookProp->edition = $bookDatas['edition'];

		return $bookProp;
	}

	/**
	 * ISBNから本情報を取得、無ければ国会図書館APIから本情報をDBに登録し取得
	 *
	 * @param array $bookDatas
	 */
	public function getOrCreateByISBNandEdition(array $bookDatas)
	{
		$bookAsc = [];

		// 本情報がDBに存在するかチェック
		if (!empty($bookDB = $this->findByISBNandEdition($bookDatas['ISBN']))) {
			return $bookDB;
		}

		// 国会図書館API
		$xml = file_get_contents("http://iss.ndl.go.jp/api/opensearch?isbn={$bookDatas['ISBN']}");
		$xmlObject = simplexml_load_string($xml);
		$catArr = [];
		foreach ($xmlObject->channel->item as $item) {
			$PubByUnixDatetime[] = json_decode(json_encode($item->pubDate), true);
			$subject = json_decode(json_encode($item->children("dc", true)->subject), true);
			foreach ($subject as $param) {
				if (preg_match( "/[ぁ-ん]+|[ァ-ヴー]+/u", $param)) {    // 日本語で記述されているカテゴリのみ取得
					$catArr[] = str_replace(array(" ", "　"), "", $param);  // 「プログラミング(コンピュータ)、プログラミング (コンピュータ)」等の混在を避ける
				}
			}
		}
		$catArr = array_values(array_unique($catArr));
		foreach($PubByUnixDatetime as $arr) {
			if (!empty($arr)) {
				$pubDateArr = $arr;
			}
		}
		$pubDate = null;    // そもそもpubDateが存在しないパターンがある 例)WEB+DB Press
		if (!empty($pubDateArr)) {
			$pubDate = date("Y-m-d", strtotime($pubDateArr[0]));
		}

		// 楽天書籍検索API
		$query = http_build_query([
			"format" => "json",
			"isbn" => $bookDatas['ISBN'],
			"applicationId" => env('RAKUTEN_BOOKS_APP_ID'),
		]);
		$json = file_get_contents("https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404?{$query}");
		$rakutenObj = json_decode($json);
		$items = $rakutenObj->Items[0]->Item;

		// 出版社 登録&id取得 or id取得
		$publisher = $this->publisherService->firstOrCreate($items->publisherName);

		$bookAsc = [
			'title' => $items->title,
			'ISBN' => $bookDatas['ISBN'],
			'edition' => $bookDatas['edition'],
			'release_date' => $pubDate,   // pubDate表記をY-m-dに変換
			'publisher_id' => $publisher['id'],
			'authors' => explode("/", $items->author),  // 配列
			'price' => $items->itemPrice,
			'img_url' => $items->largeImageUrl,
			'categories' => $catArr,  // 配列
		];

		// 本登録&著者登録&カテゴリ登録
		$query = $this->book->create($bookAsc);
		$query->authors()->sync($this->authorService->firstOrCreate($bookAsc['authors']));
		$query->categories()->sync($this->categoryService->firstOrCreate($bookAsc['categories']));

		// DBから取得
		$bookData = $this->findByISBNandEdition($bookDatas['ISBN']);

		return $bookData;
	}


	/**
	 * ISBNと版数からDBより本情報を取得する
	 *
	 * @param string $ISBN
	 * @param int $edition
	 * @return object $bookObj
	 */
	public function findByISBNandEdition(string $ISBN, int $edition = 1)
	{
		$query = $this->book
			->where('ISBN', $ISBN)
			->where('edition', $edition)
			->with(['categories' => function ($q) {
				$q->select(['categories.id', 'categories.name']);
				}])
			->with(['publishers' => function ($q) {
					$q->select(['publishers.id', 'publishers.name']);
				}])
			->with(['authors' => function ($q) {
					$q->select(['authors.id', 'authors.name']);
				}]);

		$bookObj = $query->first();
		return $bookObj;
	}

	/**
	 * 本idからDBより本情報を取得する
	 *
	 * @param int $bookId 本id
	 * @return object $bookObj
	 */
	function findByThisId(int $bookId)
	{
		$query = $this->book
			->where('id', $bookId)
			->with(['categories' => function ($q) {
					$q->select(['categories.id', 'categories.name']);
				}])
			->with(['publishers' => function ($q) {
					$q->select(['publishers.id', 'publishers.name']);
				}])
			->with(['authors' => function ($q) {
					$q->select(['authors.id', 'authors.name']);
				}]);

		$bookObj = $query->first();

		return $bookObj;
	}
}
