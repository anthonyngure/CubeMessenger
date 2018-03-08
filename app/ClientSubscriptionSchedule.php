<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ClientSubscriptionSchedule
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $client_subscription_id
 * @property int|null $subscription_schedule_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionSchedule whereClientSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionSchedule whereSubscriptionScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ClientSubscriptionSchedule whereUpdatedAt($value)
 */
class ClientSubscriptionSchedule extends Model
{
    //
	protected $guarded = [
		'id', 'created_at', 'updated_at',
	];
}
