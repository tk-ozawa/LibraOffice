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

Route::get('/search', 'BookController@goSearch')->name('search');
Route::get('/search/order/input', 'BookController@goOrderByISBN');
Route::get('/order/input', 'BookController@goOrder');
Route::get('/order', 'BookController@order');

Route::get('/master', 'MasterController@goTop')->name('master.top');
Route::get('/master/user/add/input', 'MasterController@goRegister')->name('user.add.input');
Route::get('/master/user/add', 'MasterController@register')->name('user.add');


Route::get('/normal', 'NormalController@goMasterTop')->name('normal.top');

