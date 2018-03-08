<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\SubscriptionType
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $delivery_base_cost Base cost for delivering the item to the client
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SubscriptionItem[] $subscriptionItems
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionType whereDeliveryBaseCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionType whereUpdatedAt($value)
 */
	class SubscriptionType extends Model
	{
		//
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function subscriptionItems()
		{
			return $this->hasMany(SubscriptionItem::class);
		}
	}
