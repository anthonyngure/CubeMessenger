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
	
	use App\LogHelper;
	use App\User;
	
	Route::get('/', function () {
		return view('layouts.app');
	});
	
	Route::group(['prefix' => 'admin'], function () {
		Voyager::routes();
	});
	
	Route::group(['prefix' => 'emails'], function () {
		Route::get('test', function () {
			Mail::raw('Sending emails with Mailgun and Laravel is easy!', function ($message) {
				$message->to('anthonyngure25@gmail.com');
			});
			/*if (count(Mail::failures()) > 0) {
				foreach (Mail::failures() as $failure) {
					LogHelper::info($failure, 'MailTest');
				}
			}*/
			
			dd(Mail::failures());
		});
		Route::get('/password', function () {
			$password = str_random(5);
			
			$user = new User([
				'department_id' => 1,
				'name'          => 'Anthony Ngure',
				'email'         => 'anthonyngure25@gmail.com',
				'account_type'  => 'DEPARTMENT_USER',
				'password'      => bcrypt($password),
			]);;
			
			Mail::to($user)->send(new \App\Mail\Password($user, $password));
			
			return new \App\Mail\Password($user, $password);
		});
	});
