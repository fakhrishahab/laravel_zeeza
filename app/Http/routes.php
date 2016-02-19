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

// Route::post('oauth/access_token', function() {
//     return Response::json(Authorizer::issueAccessToken());
// });

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
	Route::get('', 'productController@index');
	Route::post('create', 'productController@create');
	Route::get('detail', 'productController@show');	
	Route::get('search', 'productController@search');
	Route::post('edit', 'productController@edit');
	Route::delete('delete', 'productController@delete');
});

Route::group(['prefix'=>'type'], function(){
	Route::get('view', 'CategoryController@getType');	
});

Route::group(['prefix'=>'menu'], function(){
	Route::get('', 'menuController@index');
	Route::get('nav', 'menuController@getNav');
	Route::get('content', 'menuController@getContent');
});


Route::get('size', 'CategoryController@getSize');
Route::get('last_code/{id?}', 'productController@getCode');

Route::get('image', 'productController@getImage');

Route::get('admin_product', 'AdminProductController@get');

Route::group(['prefix'=>'admin_content'], function(){
	Route::get('menu', 'adminContentController@getMenu');
	Route::get('menu_detail', 'adminContentController@getMenuDetail');
});

// Route::post('login', 'AdminLoginController@store');

Route::group(['prefix'=>'admin_category'], function(){
	Route::get('', 'AdminCategoryController@index');
	Route::post('create', 'AdminCategoryController@create');
	Route::get('detail','AdminCategoryController@detail');	
	Route::put('edit', 'AdminCategoryController@edit');
	Route::delete('delete', 'AdminCategoryController@delete');
});

Route::group(['prefix'=>'admin_type'], function(){
	Route::get('', 'AdminTypeController@index');
	Route::get('detail','AdminTypeController@detail');
	Route::post('create', 'AdminTypeController@create');
	Route::put('edit','AdminTypeController@edit');
	Route::delete('delete', 'AdminTypeController@delete');
});

Route::group(['prefix'=>'admin_brand'], function(){
	Route::get('','AdminBrandController@index');
	Route::get('detail','AdminBrandController@detail');
	Route::post('create', 'AdminBrandController@create');
	Route::put('edit','AdminBrandController@edit');
	Route::delete('delete', 'AdminBrandController@delete');
});

Route::group(['prefix'=>'admin_size'], function(){
	Route::get('','AdminSizeController@index');
	Route::get('detail','AdminSizeController@detail');
	Route::post('create', 'AdminSizeController@create');
	Route::put('edit','AdminSizeController@edit');
	Route::delete('delete', 'AdminSizeController@delete');
});

Route::group(['prefix'=>'admin_menu'], function(){
	Route::get('','AdminMenuController@index');
	Route::get('detail','AdminMenuController@detail');
	Route::post('create', 'AdminMenuController@create');
	Route::put('edit','AdminMenuController@edit');
	Route::delete('delete', 'AdminMenuController@delete');
});