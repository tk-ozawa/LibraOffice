<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Services\CategoryService;
use App\Services\PublisherService;
use App\Services\PurchaseService;
use App\Services\OrderService;
use App\Services\AuthorService;
use App\Services\UserService;
use App\Services\RentalService;
use App\Models\Database\BookProp;
use App\Models\Database\AuthorProp;
use App\Models\Database\CategoryProp;
use App\Models\Database\PublisherProp;

class BookController extends Controller
{
	private $book;
	private $publisher;
	private $author;
	private $category;
	private $order;
	private $purchase;
	private $rental;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	function __construct(BookService $book, PublisherService $publisher, AuthorService $author, CategoryService $category, OrderService $order, PurchaseService $purchase, RentalService $rental)
	{
		$this->book = $book;
		$this->publisher = $publisher;
		$this->author = $author;
		$this->category = $category;
		$this->order = $order;
		$this->purchase = $purchase;
		$this->rental = $rental;
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
		$publisher = $this->publisher->findById($book->publisher_id);

		$book->edition = $input['edition'];

		return view('book.order.orderISBN', compact('book', 'publisher'));
	}

	/**
	 * ISBN無し書籍注文依頼画面表示処理
	 */
	public function goOrder(Request $request)
	{
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
		$authorsDB = $this->author->findById($bookDB->id);
		$authorsProp = [];

		foreach ($authorsDB as $authorDB) {	// 配列 -> obj
			$authorProp = new authorProp();
			$authorProp->id = $authorDB->id;
			$authorProp->name = $authorDB->name;

			$authorsProp[] = $authorProp;
		}
		$bookProp->authors = $authorsProp;

		// カテゴリ取得
		$categoriesDB = $this->category->findByBookId($bookDB->id);
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

	/**
	 * 社内図書詳細画面表示処理
	 */
	public function goBookDetail(Request $request, int $purchaseId)
	{
		$purchase = $this->purchase->findById($purchaseId);
		$book = $purchase->books;
		$publisher = $book->publishers;
		$categories = $book->categories;
		$authors = $book->authors;

		// 借りたことのあるユーザーとその回数を取得
		$rentals = $this->rental->getRentaledUsersAndCount($purchaseId);

		// 貸出中かどうか
		$isRentalUserArr = $this->rental->isRentalUser($purchase->id);

		return view('book.detail', compact('purchase', 'book', 'publisher', 'rentals', 'isRentalUserArr', 'categories', 'authors'));
	}

	/**
	 * 貸出申請処理
	 */
	public function rental(Request $request, int $purchaseId)
	{
		$session = $request->session()->all();

		$purchase = $this->rental->apply($purchaseId, $session['id']);
		$book = $purchase->books;

		$flashMsg = "ID:{$book->id}, タイトル:{$book->title}の貸出申請を提出しました。";

		if ($session['auth'] === 0) {
			return redirect(route('master.top'))->with('flashMsg', $flashMsg);
		}

		return redirect(route('normal.top'))->with('flashMsg', $flashMsg);
	}

	/**
	 * 返却申請処理
	 */
	public function return(Request $request, int $purchaseId)
	{
		$session = $request->session()->all();

		$purchase = $this->rental->return($purchaseId, $session['id']);
		$book = $purchase->books;

		$flashMsg = "ID:{$book->id}, タイトル:{$book->title}を返却しました。";

		if ($session['auth'] === 0) {
			return redirect(route('master.top'))->with('flashMsg', $flashMsg);
		}

		return redirect(route('normal.top'))->with('flashMsg', $flashMsg);
	}

	/**
	 * タイトルによる書籍検索結果画面表示処理
	 */
	public function findTitle(Request $request)
	{
		$input = $request->all();
		$keyword = $input['keyword'];

		$hitPurchases = $this->purchase->findByKeyword($keyword);

		if (!$hitPurchases) {
			$valiMsg = "タイトルに{$keyword}を含む書籍はありませんでした。";
			return view('book.find.notfound', compact('valiMsg'));
		}

		$hitCount = count($hitPurchases);

		return view('book.find.title', compact('keyword', 'hitPurchases', 'hitCount'));
	}

	/**
	 * カテゴリー名による書籍検索結果画面表示処理
	 */
	public function findByCategoryName(Request $request, string $categoryName)
	{
		$category = $this->category->findByName($categoryName);

		$hitPurchases = $this->purchase->findByCategoryId($category->id);

		if (!$hitPurchases) {	//今のところ通り得ない
			$valiMsg = "カテゴリ:\"{$category->name}\"の書籍はありませんでした。";
			return view('book.find.notfound', compact('valiMsg'));
		}

		$hitCount = count($hitPurchases);

		return view('book.find.category', compact('hitPurchases', 'hitCount', 'category'));
	}

	/**
	 * 出版社IDによる書籍検索結果画面表示処理
	 */
	public function findByPublisherId(Request $request, int $publisherId)
	{
		$publisher = $this->publisher->findById($publisherId);

		$hitPurchases = $this->purchase->findByPublisherId($publisherId);

		if (!$hitPurchases) {	//今のところ通り得ない
			$valiMsg = "\"{$publisher->name}\"が出版している書籍はありませんでした。";
			return view('book.find.notfound', compact('valiMsg'));
		}

		$hitCount = count($hitPurchases);

		return view('book.find.publisher', compact('hitPurchases', 'hitCount', 'publisher'));
	}
}
