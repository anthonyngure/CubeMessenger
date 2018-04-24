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
	
	Route::get('/', function () {
		return view('layouts.app');
	});
	
	
	Route::group(['prefix' => 'emails'], function () {
		Route::get('/', 'TestEmailsController@demo');
		Route::get('/demo', 'TestEmailsController@demo');
		Route::get('/topUp', 'TestEmailsController@topUp');
		Route::get('/serviceRequestQuote', 'TestEmailsController@serviceRequestQuote');
	});
	
	Route::get('acceptServiceRequestQuote/{id}', 'ServiceRequestQuoteController@acceptQuote');
	Route::get('rejectServiceRequestQuote/{id}', 'ServiceRequestQuoteController@rejectQuote');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
