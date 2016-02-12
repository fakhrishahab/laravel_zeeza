<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
Route::group(['prefix'=>'category'], function(){
	Route::get('view', 'CategoryController@getCategory');	
});

Route::group(['prefix'=>'brand'], function(){
	Route::get('view', 'productController@getBrand');	
});

Route::group(['prefix'=>'product'], function(){
	Route::post('create', 'productController@create');
});

Route::group(['prefix'=>'type'], function(){
	Route::get('view', 'CategoryController@getType');	
});


Route::get('size', 'CategoryController@getSize');
Route::get('last_code/{id?}', 'productController@getCode');

Route::get('image', 'productController@getImage');

Route::get('admin_product', 'adminProductController@get');