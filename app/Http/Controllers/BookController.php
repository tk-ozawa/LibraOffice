<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Services\CategoryService;
use App\Services\PublisherService;
use App\Services\OrderService;
use App\Services\AuthorService;
use App\Models\Database\BookProp;
use App\Models\Database\AuthorProp;
use App\Models\Database\CategoryProp;
use App\Models\Database\PublisherProp;

class BookController extends Controller
{
	private $request;
	private $book;
	private $publisher;
	private $author;
	private $category;
	private $order;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	function __construct(BookService $book, PublisherService $publisher, AuthorService $author, CategoryService $category, OrderService $order)
	{
		$this->book = $book;
		$this->publisher = $publisher;
		$this->author = $author;
		$this->category = $category;
		$this->order = $order;
	}

	/**
	 * 書籍情報検索画面表示処理
	 */
	public static function goSearch()
	{
		return view('book.order.search');
	}

	/**
	 * ISBN有り書籍注文依頼画面表示処理
	 */
	public function goOrderByISBN(Request $request)
	{
		$input = $request->all();

		// DB登録済チェック
		if ($this->book->exists($input['ISBN'], $input['edition'])) {
			return redirect('/search')->with('infoMsg', "書籍情報は登録済みです。ISBN:{$input['ISBN']}, 第{$input['edition']}版");
		}

		// 本情報取得
		$book = $this->book->getByISBN($input);

		if (!$book) {
			// 検索画面に戻る
			return redirect('/search')->with('valiMsg', "書籍情報がヒットしませんでした。ISBN:{$input['ISBN']}, 第{$input['edition']}版");
		}

		// 出版社情報取得
		$publisher = $this->publisher->getByID($book->publisher_id);

		$book->edition = $input['edition'];

		return view('book.order.orderISBN', compact('book', 'publisher'));
	}

	/**
	 * ISBN無し書籍注文依頼画面表示処理
	 */
	public function goOrder(Request $request)
	{
		/**
		 * 必要：
		 * 		title
		 * 		price
		 * 		release_date
		 * 		publisher (同人誌の場合:'同人誌') 将来的にはラジオボタンで切り替え
		 * 		authors (配列)
		 * 		categories (配列)
		 * 		edition : 1固定
		 * NULL：
		 * 		img_url
		 * 		ISBN
		 */
		return view('book.order.orderNoISBN');
	}

	/**
	 * 注文確認画面
	 */
	public function orderConfirm(Request $request)
	{
		$input = $request->all();

		$bookProp = new BookProp();
		foreach ($input as $key => $val) {
			$bookProp->$key = $val;
		}

		// 出版社DB登録->取得 | 取得
		$publisher = $this->publisher->firstOrCreate($bookProp->publisher);

		$book = $bookProp;

		dd($book);

		return view('book.order.orderConfirm', compact('book'));
	}

	/**
	 * 注文処理
	 */
	public function order(Request $request)
	{
		/**
		 * メモ 1/10
		 * ISBN無し->(取得|登録->取得) 完成
		 */

		$input = $request->all();

		$bookProp = new BookProp();
		foreach ($input as $key => $val) {
			$bookProp->$key = $val;
		}

		// 出版社DB登録->取得 | 取得
		$publisher = $this->publisher->firstOrCreate($bookProp->publisher);

		$publisherProp = new PublisherProp();
		$publisherProp->id = $publisher->id;
		$publisherProp->name = $bookProp->publisher;

		$bookProp->publisher_id = $publisher->id;


		// 出版社情報もModelで持ち回るべき？

		// 書籍登録&著者登録&カテゴリ登録
		$bookDB = $this->book->firstOrCreate($bookProp);
		$bookProp->id = $bookDB->id;
		$bookDB->authors()->sync($this->author->firstOrCreate(explode(',', $bookProp->authors)));
		$bookDB->categories()->sync($this->category->firstOrCreate(explode(',', $bookProp->categories)));

		// 著者取得
		$authorsDB = $this->author->getByBookId($bookDB->id);
		$authorsProp = [];

		foreach ($authorsDB as $authorDB) {	// 配列 -> obj
			$authorProp = new authorProp();
			$authorProp->id = $authorDB->id;
			$authorProp->name = $authorDB->name;

			$authorsProp[] = $authorProp;
		}
		$bookProp->authors = $authorsProp;

		// カテゴリ取得
		$categoriesDB = $this->category->getByBookId($bookDB->id);
		$categoriesProp = [];

		foreach ($categoriesDB as $categoryDB) {	// 配列 -> obj
			$categoryProp = new categoryProp();
			$categoryProp->id = $categoryDB->id;
			$categoryProp->name = $categoryDB->name;

			$categoriesProp[] = $categoryProp;
		}
		$bookProp->categories = $categoriesProp;

		$session = $request->session()->all();

		// 注文処理
		$this->order->createRequest($session['id'], $bookProp->id, $session['office_id']);

		return view('book.order.orderComplete', compact('bookProp', 'publisherProp'));
	}
}
