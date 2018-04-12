<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
	 * App\Subscription
	 *
	 * @property int                              $id
	 * @property int                              $user_id
	 * @property int                              $subscription_option_item_id
	 * @property string                           $weekdays
	 * @property float                            $amount
	 * @property float                            $delivery_fee
	 * @property float                            $item_cost
	 * @property bool                             $renew_every_month
	 * @property string|null                      $termination_date
	 * @property int                              $quantity
	 * @property string                           $status
	 * @property int|null                         $rejected_by_id
	 * @property \Carbon\Carbon|null              $created_at
	 * @property \Carbon\Carbon|null              $updated_at
	 * @property string|null                      $deleted_at
	 * @property-read \App\SubscriptionOptionItem $optionItem
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereAmount($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereDeletedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereDeliveryFee($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereItemCost($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereQuantity($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereRejectedById($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereRenewEveryMonth($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereStatus($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereSubscriptionOptionItemId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereTerminationDate($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereUpdatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereUserId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subscription whereWeekdays($value)
	 * @mixin \Eloquent
	 */
	class Subscription extends Model
	{
		//
		
		protected $casts = [
			'renew_every_month' => 'boolean',
		];
		
		protected $guarded = [
			'id', 'created_at', 'updated_at',
		];
		
		protected $hidden = [
			'user_id',
			'rejected_by_id',
			'subscription_option_item_id',
		];
		
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function optionItem()
		{
			return $this->belongsTo(SubscriptionOptionItem::class, 'subscription_option_item_id');
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function rejectedBy()
		{
			return $this->belongsTo(User::class, 'rejected_by_id');
		}
	}
