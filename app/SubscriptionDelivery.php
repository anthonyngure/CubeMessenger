<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\ClientSubscriptionDelivery
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $client_subscription_id
 * @property int $item_cost Retail price of the item at the time of delivery
 * @property int $delivery_cost includes delivery base cost of the item and cost based on distance
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionDelivery whereClientSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionDelivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionDelivery whereDeliveryCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionDelivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionDelivery whereItemCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionDelivery whereUpdatedAt($value)
 * @property int $subscription_id
 * @property int $received_by_id
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionDelivery whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionDelivery whereReceivedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionDelivery whereSubscriptionId($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\SubscriptionDelivery onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\SubscriptionDelivery withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SubscriptionDelivery withoutTrashed()
 */
class SubscriptionDelivery extends Model
{
    //
	use SoftDeletes;
}
