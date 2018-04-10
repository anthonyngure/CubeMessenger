<?php
	
	namespace App\Http\Controllers;
	
	use App\SubscriptionType;
	use Illuminate\Database\Eloquent\Relations\HasMany;
	use Illuminate\Database\Eloquent\Relations\HasOne;
	
	class SubscriptionTypeController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			//
			
			$data = SubscriptionType::with(['subscriptionItems' => function (HasMany $hasMany) {
				$hasMany->with(['clientSubscription' => function (HasOne $hasOne) {
					$hasOne->with('subscriptionSchedules');
				}]);
			}])->get();
			
			return $this->collectionResponse($data);
		}
		
	}
