<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SubscriptionItem
 *
 * @property int $id
 * @property string $name
 * @property int|null $subscription_type_id
 * @property int $item_cost Current retail price of the item
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\ClientSubscription $clientSubscription
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionItem whereItemCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionItem whereSubscriptionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubscriptionItem extends Model
{
    //
	
	public function clientSubscription()
	{
		return $this->hasOne(ClientSubscription::class);
	}
}
