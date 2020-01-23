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

Route::get('/', 'UserController@goLogin');
Route::get('/login', 'UserController@login');

Route::group(['middleware' => ['CheckRegistered']], function () {
	Route::get('/search', 'BookController@goSearch')->name('search');
	Route::get('/search/order/input', 'BookController@goOrderByISBN');
	Route::get('/order/input', 'BookController@goOrder');
	Route::get('/order', 'BookController@order');

	Route::get('/book/{purchaseId}', 'BookController@goBookDetail')->name('book.detail');
	Route::get('/book/{purchaseId}/rental', 'BookController@rental')->name('book.rental');
	Route::get('/book/{purchaseId}/return', 'BookController@return')->name('book.return');

	Route::get('/normal', 'NormalController@goTop')->name('normal.top');

	Route::group(['middleware' => ['CheckMasterAuth']], function () {
		Route::get('/master', 'MasterController@goTop')->name('master.top');
		Route::get('/master/user/add/input', 'MasterController@goRegister')->name('user.add.input');
		Route::get('/master/user/add', 'MasterController@register')->name('user.add');

		Route::get('/master/order/accept/{orderId}', 'MasterController@goOrderAccept')->name('order.accept.confirm');
		Route::get('/master/order/accept', 'MasterController@orderAccept')->name('order.accept');
		Route::get('/master/purchase/complete/{purchaseId}', 'MasterController@goPurchaseComplete')->name('purchase.complete.confirm');
		Route::get('/master/purchase/complete', 'MasterController@purchaseComplete')->name('purchase.complete');
	});
});


