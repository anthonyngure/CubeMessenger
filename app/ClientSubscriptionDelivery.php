<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionDelivery whereClientSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionDelivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionDelivery whereDeliveryCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionDelivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionDelivery whereItemCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionDelivery whereUpdatedAt($value)
 */
class ClientSubscriptionDelivery extends Model
{
    //
}
