<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::get('/home', function () {
	return view('welcome');
});

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['prefix'=>'admin', 'middleware'=>'auth.checkrole:admin', 'as'=>'admin.'], function(){

	Route::group(['prefix'=>'categories', 'as'=>'categories.'], function(){
		Route::get('/index',['as'=>'index', 'uses'=>'CategoriesController@index']);
		Route::get('/create',['as'=>'create', 'uses'=>'CategoriesController@create']);
		Route::get('/edit/{id}',['as'=>'edit', 'uses'=>'CategoriesController@edit']);
		Route::post('/update/{id}',['as'=>'update', 'uses'=>'CategoriesController@update']);
		Route::post('/sotre',['as'=>'store', 'uses'=>'CategoriesController@store']);
	});

	Route::group(['prefix'=>'products', 'as'=>'products.'], function(){
		Route::get('/index',['as'=>'index', 'uses'=>'ProductsController@index']);
		Route::get('/create',['as'=>'create', 'uses'=>'ProductsController@create']);
		Route::get('/edit/{id}',['as'=>'edit', 'uses'=>'ProductsController@edit']);
		Route::post('/update/{id}',['as'=>'update', 'uses'=>'ProductsController@update']);
		Route::post('/sotre',['as'=>'store', 'uses'=>'ProductsController@store']);
		Route::get('/destroy/{id}',['as'=>'destroy', 'uses'=>'ProductsController@destroy']);
	});

	Route::group(['prefix'=>'clients', 'as'=>'clients.'], function(){
		Route::get('/index',['as'=>'index', 'uses'=>'ClientsController@index']);
		Route::get('/create',['as'=>'create', 'uses'=>'ClientsController@create']);
		Route::get('/edit/{id}',['as'=>'edit', 'uses'=>'ClientsController@edit']);
		Route::post('/update/{id}',['as'=>'update', 'uses'=>'ClientsController@update']);
		Route::post('/sotre',['as'=>'store', 'uses'=>'ClientsController@store']);
		Route::get('/destroy/{id}',['as'=>'destroy', 'uses'=>'ClientsController@destroy']);
	});

	Route::group(['prefix'=>'orders', 'as'=>'orders.'], function(){
		Route::get('/index',['as'=>'index', 'uses'=>'OrdersController@index']);
		Route::get('/edit/{id}',['as'=>'edit', 'uses'=>'OrdersController@edit']);
		Route::post('/update/{id}',['as'=>'update', 'uses'=>'OrdersController@update']);
	});

	Route::group(['prefix'=>'cupoms', 'as'=>'cupoms.'], function(){
		Route::get('/index',['as'=>'index', 'uses'=>'CupomsController@index']);
		Route::get('/crate',['as'=>'create', 'uses'=>'CupomsController@create']);
		Route::post('/store',['as'=>'store', 'uses'=>'CupomsController@store']);
	});

});

Route::group(['prefix'=>'customer', 'middleware'=>'auth.checkrole:client', 'as'=>'customer.'], function(){

	Route::get('order', ['as'=>'order.index', 'uses'=>'CheckoutController@index']);
	Route::get('order/create', ['as'=>'order.create', 'uses'=>'CheckoutController@create']);
	Route::post('order/store', ['as'=>'order.store', 'uses'=>'CheckoutController@store']);
});



Route::group(['prefix'=>'api', 'middleware'=>'oauth', 'as'=>'api.'], function(){

	Route::get('teste', function() {
		return [
			'teste' => 'ok!',
			];
	});

	Route::group(['prefix'=>'client', 'middleware'=>'oauth.checkrole:client', 'as'=>'client.'], function(){

		Route::resource('order', 
			'Api\Client\ClientCheckoutController', [
				'except' => ['create', 'edit', 'destroy'] //essa linha informa quais metodos http ele não deve criar
			]
		);

	});

	Route::group(['prefix'=>'deliveryman', 'middleware'=>'oauth.checkrole:deliveryman', 'as'=>'deliveryman.'], function(){
		
		Route::resource('order', 
			'Api\Deliveryman\DeliverymanCheckoutController', [
				'except' => ['create', 'edit', 'store', 'destroy'] //essa linha informa quais metodos http ele não deve criar
			]
		);

		Route::patch('order/update-status/{id}', [ 
			'uses' => 'Api\Deliveryman\DeliverymanCheckoutController@updateStatus', 
			'as' => 'orders.update-status' 
		]);

	});

	Route::get('authenticated', 
		'Api\Client\ClientCheckoutController', [
			'except' => ['create', 'edit', 'destroy'] //essa linha informa quais metodos http ele não deve criar
		]
	);

});

