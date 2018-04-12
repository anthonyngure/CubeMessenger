<?php
	
	namespace App\Providers;
	
	use App\Category;
	use App\Charge;
	use App\Delivery;
	use App\DeliveryItem;
	use App\Observers\CategoryObserver;
	use App\Observers\ChargeObserver;
	use App\Observers\DeliveryObserver;
	use App\Observers\ProductObserver;
	use App\Item;
	use App\Observers\ShopOrderObserver;
	use App\Observers\SubscriptionObserver;
	use App\Observers\TopUpObserver;
	use App\Observers\UserObserver;
	use App\ShopOrder;
	use App\Subscription;
	use App\TopUp;
	use App\User;
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
			/**
			 * Registering model observers
			 */
			User::observe(UserObserver::class);
			Charge::observe(ChargeObserver::class);
			Delivery::observe(DeliveryObserver::class);
			ShopOrder::observe(ShopOrderObserver::class);
			Subscription::observe(SubscriptionObserver::class);
			
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
