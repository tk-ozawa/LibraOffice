<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/foo', function () {
	return view('welcome');
});

Route::get('/', 'UserController@goLogin')->name('login.form');
Route::post('/login', 'UserController@login')->name('login');

Route::get('/office', 'OfficeController@goTop')->name('office.top');
Route::get('/office/add/input', 'OfficeController@goRegister')->name('office.register.input');
Route::post('/office/add', 'OfficeController@register')->name('office.register');

Route::group(['middleware' => ['CheckRegistered']], function () {
	Route::post('/logout', 'UserController@logout')->name('logout');

	Route::get('/mypage', 'UserController@goMypage')->name('mypage');
	Route::post('/profile/edit', 'UserController@editProfile')->name('mypage.profile.edit');

	Route::get('/timeline/json', 'UserController@timelineJSON')->name('timeline.json');
	Route::get('/timeline', 'UserController@goTimeline')->name('timeline');
	Route::post('/timeline/reaction', 'UserController@reaction')->name('reaction');

	Route::get('/search', 'BookController@goSearch')->name('search');
	Route::get('/search/order/input', 'BookController@goOrderByISBN')->name('search.order.input');
	Route::get('/order/input', 'BookController@goOrder')->name('order.input');
	Route::get('/order', 'BookController@order')->name('order');

	Route::get('/book/{purchaseId}', 'BookController@goBookDetail')->name('book.detail');
	Route::get('/book/{purchaseId}/rental', 'BookController@rental')->name('book.rental');
	Route::post('/book/{purchaseId}/rental', 'BookController@rentalJSON')->name('book.rental.json');
	Route::get('/book/{purchaseId}/return', 'BookController@return')->name('book.return');
	Route::post('/book/{purchaseId}/return', 'BookController@returnJSON')->name('book.return.json');

	Route::get('/book/find/title', 'BookController@findTitle')->name('book.find.title');
	Route::get('/book/find/category/{categoryName}', 'BookController@findByCategoryName')->name('book.find.category');
	Route::get('/book/find/publisher/{publisherId}', 'BookController@findByPublisherId')->name('book.find.publisher');
	Route::get('/book/find/user/{userId}', 'BookController@findByUserId')->name('book.find.user');

	Route::get('/book/find/author/{authorId}', 'BookController@findByAuthorId')->name('book.find.author');

	Route::get('/normal', 'NormalController@goTop')->name('normal.top');
	Route::get('/purchases/json', 'BookController@purchasesJSON')->name('purchases.json');
	Route::get('/rentals/json', 'BookController@rentalsJSON')->name('rentals.json');

	Route::get('/normal/settings', 'NormalController@goSettings')->name('mypage.settings.normal');

	Route::get('/user/detail/{userId}', 'UserController@goDetail')->name('user.detail');

	Route::get('/user/list', 'UserController@goList')->name('user.list');

	Route::group(['middleware' => ['CheckMasterAuth']], function () {
		Route::get('/master', 'MasterController@goTop')->name('master.top');

		Route::get('/master/user/add/input', 'MasterController@goRegister')->name('user.add.input');
		Route::post('/master/user/add', 'MasterController@register')->name('user.add');

		Route::get('/master/order/accept/{orderId}', 'MasterController@goOrderAccept')->name('order.accept.confirm');
		Route::get('/master/order/accept', 'MasterController@orderAccept')->name('order.accept');
		Route::get('/master/order/reject/{orderId}', 'MasterController@goOrderReject')->name('order.reject.input');
		Route::get('/master/order/reject', 'MasterController@orderReject')->name('order.reject');

		Route::get('/master/purchase/complete/{purchaseId}', 'MasterController@goPurchaseComplete')->name('purchase.complete.confirm');
		Route::get('/master/purchase/complete', 'MasterController@purchaseComplete')->name('purchase.complete');

		Route::get('/master/settings', 'MasterController@goSettings')->name('mypage.settings.master');
	});
});


