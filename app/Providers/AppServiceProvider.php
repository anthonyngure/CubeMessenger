<?php
	
	namespace App\Providers;
	
	use App\Category;
	use App\Observers\CategoryObserver;
	use App\Observers\ProductObserver;
	use App\Item;
	use Illuminate\Support\ServiceProvider;
	use Schema;
	
	class AppServiceProvider extends ServiceProvider
	{
		/**
		 * Bootstrap any application services.
		 *
		 * @return void
		 */
		public function boot()
		{
			//
			
			Schema::defaultStringLength(191);
		}
		
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			//
		}
	}
