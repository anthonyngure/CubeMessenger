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
	
	ob_start('ob_gzhandler');
	
	
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
			Route::get('auth/user', 'AuthController@user');
			Route::resource('deliveries', 'DeliveryController');
			Route::resource('deliveries.items', 'DeliveryItemController');
			Route::resource('subscriptions', 'SubscriptionController');
			Route::resource('appointments', 'AppointmentController');
			Route::resource('shopProducts', 'ShopProductController');
			Route::resource('shopCategories', 'ShopCategoryController');
			Route::resource('serviceRequests', 'ServiceRequestController');
			Route::resource('serviceRequestOptions', 'ServiceRequestOptionController');
			Route::resource('shopOrders', 'ShopOrderController');
		});
		
	});


