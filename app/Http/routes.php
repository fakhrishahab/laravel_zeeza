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

Route::get('category', 'CategoryController@getCategory');
Route::get('type/{id?}', 'CategoryController@getType');
Route::get('size', 'CategoryController@getSize');
Route::get('brand', 'productController@getBrand');
Route::get('last_code/{id?}', 'productController@getCode');

Route::post('product', 'productController@create');
Route::get('image', 'productController@getImage');

Route::get('admin_product', 'adminProductController@get');