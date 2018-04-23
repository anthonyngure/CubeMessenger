<?php
	
	use Illuminate\Routing\Router;
	
	Admin::registerAuthRoutes();
	
	Route::group([
		'prefix'     => config('admin.route.prefix'),
		'namespace'  => config('admin.route.namespace'),
		'middleware' => config('admin.route.middleware'),
	], function (Router $router) {
		
		$router->get('/', 'HomeController@index');
		
		$router->resource('clients', 'ClientController');
		$router->get('api/clients', 'ApiController@clients');
		$router->resource('users', 'UserController');
		$router->group(['prefix' => 'shopping'], function () use ($router) {
			$router->resource('orders', 'ShopOrderController');
			$router->resource('products', 'ShopProductController');
			$router->resource('categories', 'ShopCategoryController');
		});
		
		$router->group(['prefix' => 'serviceRequests'], function () use ($router) {
			$router->resource('requests', 'ServiceRequestController');
			$router->resource('quotes', 'ServiceRequestQuoteController');
		});
		
		
	});
