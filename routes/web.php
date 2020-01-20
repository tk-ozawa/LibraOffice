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

Route::get('/search', 'BookController@goSearch');
Route::get('/search/order/input', 'BookController@goOrderByISBN');
Route::get('/order/input', 'BookController@goOrder');
Route::get('/order', 'BookController@order');

Route::get('/', 'UserController@goLogin');
Route::get('/login', 'UserController@login');

Route::get('/top', 'UserController@goTop')->name('top');

Route::get('/test', 'UserController@register');
Route::get('/user/input', 'UserController@goRegister');
Route::get('/user/add', 'UserController@register')->name('user.add');
