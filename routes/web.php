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

Auth::routes();
Route::get('/', 'Auth\IndexController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['namespace' => 'Api','middleware' => ['checkalc','auth']],function(){
	//用户管理
	Route::get('/api/user','AlcController@index');
	Route::post('/api/user/add','AlcController@addUser');
	Route::post('/api/user/del','AlcController@delUser');
	Route::get('/api/user/alc/list','AlcController@queryAlcList');
	Route::post('/api/user/add/alc','AlcController@addAlc');
	//商品管理
	Route::get('/api/goods','GoodsController@index');
	Route::post('/api/goods/add','GoodsController@add');
	Route::post('/api/goods/del','GoodsController@del');
	Route::post('/api/goods/update','GoodsController@update');
	//分类管理
	Route::get('/api/cate','CatesController@index');
	Route::post('/api/cate/add','CatesController@add');
	Route::post('/api/cate/del','CatesController@del');
	Route::post('/api/cate/update','CatesController@update');
	//订单管理
	Route::get('/api/order','OrderController@index');
	Route::post('/api/order/add','OrderController@add');
	Route::post('/api/order/update','OrderController@update');
	Route::post('/api/order/del','OrderController@del');
	Route::get('/api/order/excel','OrderController@excel');
});