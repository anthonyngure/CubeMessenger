<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\ClientSubscription
 *
 * @property int                 $id
 * @property int|null            $client_id
 * @property int|null            $subscription_id
 * @property int                 $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscription whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscription whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscription whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscription whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SubscriptionSchedule[] $subscriptionSchedules
 * @property int|null $subscription_item_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscription whereSubscriptionItemId($value)
 */
	class ClientSubscription extends Model
	{
		//
		
		protected $guarded = [
			'id', 'created_at', 'updated_at',
		];
		
		protected $hidden = [
			'client_id',
			'subscription_item_id',
		];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
		 */
		public function subscriptionSchedules()
		{
			return $this->belongsToMany(SubscriptionSchedule::class, 'client_subscription_schedules');
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function subscriptionItem()
		{
			return $this->belongsTo(SubscriptionSchedule::class);
		}
	}
