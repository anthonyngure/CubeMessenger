<?php
	
	/*
	|--------------------------------------------------------------------------
	| API Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register API routes for your application. These
	| routes are loaded by the RouteServiceProvider within a group which
	| is assigned the "api" middleware group. Enjoy building your API!
	|
	*/
	
	
	sleep(0);
	
	//ob_start('ob_gzhandler');
	
	
	Route::group(['prefix' => 'v1', 'guard' => 'api'], function () {
		
		Route::get('/', function () {
			return response('Cube Messenger API Version 1');
		});
		
		Route::get('/sms', function () {
			//http://107.20.199.106/api/v3/sendsms/plain?user=CubeCare&password=Rsmry2ve&sender=Cube-Movers&SMSText=text&GSM=254723203475
			
			$message = "I'm a lumberjack and its ok, I sleep all night and I work all day";
			$number = \App\Utils::normalizePhone("0723203475");
			$url = "http://107.20.199.106/api/v3/sendsms/plain";
			$client = new GuzzleHttp\Client();
			$res = $client->get($url, [
				'query' => [
					'user'     => 'CubeCare',
					'password' => 'Rsmry2ve',
					'sender'   => 'Cube-Movers',
					'SMSText'  => $message,
					'GSM'      => $number,
				],
			]);
			
			return $res->getStatusCode();
			//return response('Cube Messenger API Version 1');
		});
		
		Route::group(['prefix' => 'auth'], function () {
			Route::post('signIn', 'AuthController@signIn');
		});
		
		Route::group(['middleware' => 'auth:api'], function () {
			Route::resource('courierOptions', 'CourierOptionController');
			Route::post('auth/signOut', 'AuthController@signOut');
			Route::get('auth/refresh', 'AuthController@refresh');
			Route::get('auth', 'AuthController@user');
			Route::get('drawerItems', 'UIController@drawerItems');
			Route::get('balance', 'UIController@balance');
			
			Route::get('user/appointments', 'UserController@appointments');
			Route::post('user/changePassword', 'UserController@changePassword');
			
			Route::apiResource('users', 'UserController')
				->middleware(\App\Http\Middleware\CheckAdminOrClientAdmin::class);
			
			Route::get('clients/search', 'ClientController@search')
				->middleware(\App\Http\Middleware\CheckAdmin::class);
			Route::apiResource('clients', 'ClientController')
				->middleware(\App\Http\Middleware\CheckAdmin::class);
			
			
			Route::apiResource('topUps', 'TopUpController')
				->middleware(\App\Http\Middleware\CheckAdmin::class);
			
			Route::apiResource('departments', 'DepartmentController');
			Route::apiResource('deliveries', 'DeliveryController');
			Route::apiResource('deliveries.items', 'DeliveryItemController');
			Route::apiResource('subscriptionOptions', 'SubscriptionOptionController')->only(['index']);
			Route::apiResource('subscriptions', 'SubscriptionController');
			
			
			Route::get('roles/search', 'RoleController@search')
				->middleware(\App\Http\Middleware\CheckAdmin::class);
			Route::apiResource('roles', 'RoleController')
				->middleware(\App\Http\Middleware\CheckAdmin::class);
			
			Route::get('appointments/userSuggestions', 'AppointmentController@userSuggestions');
			Route::apiResource('appointments', 'AppointmentController');
			
			Route::apiResource('products', 'ProductController');
			Route::apiResource('categories', 'CategoryController');
			Route::apiResource('serviceRequests', 'ServiceRequestController');
			Route::apiResource('serviceRequestQuotes', 'ServiceRequestQuoteController');
			Route::apiResource('serviceRequestOptions', 'ServiceRequestOptionController');
			Route::apiResource('orders', 'OrderController');
			Route::apiResource('orders.products', 'OrderProductController');
			Route::apiResource('reports', 'ReportsController')->only(['index']);
		});
		
	});


