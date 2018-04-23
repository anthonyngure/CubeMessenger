<?php
	
	namespace App\Providers;
	
	use App\Category;
	use App\Charge;
	use App\Delivery;
	use App\Item;
	use App\Observers\CategoryObserver;
	use App\Observers\ChargeObserver;
	use App\Observers\DeliveryObserver;
	use App\Observers\ProductObserver;
	use App\Observers\ServiceRequestObserver;
	use App\Observers\ShopOrderObserver;
	use App\Observers\SubscriptionObserver;
	use App\Observers\TopUpObserver;
	use App\Observers\UserObserver;
	use App\ServiceRequest;
	use App\ShopOrder;
	use App\Subscription;
	use App\TopUp;
	use App\User;
	use Encore\Admin\Config\Config;
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
			TopUp::observe(TopUpObserver::class);
			Charge::observe(ChargeObserver::class);
			Delivery::observe(DeliveryObserver::class);
			ShopOrder::observe(ShopOrderObserver::class);
			Subscription::observe(SubscriptionObserver::class);
			ServiceRequest::observe(ServiceRequestObserver::class);
			
			Schema::defaultStringLength(191);
			
			Config::load();
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
