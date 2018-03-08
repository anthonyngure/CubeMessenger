<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SubscriptionSchedule
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionSchedule whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionSchedule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionSchedule whereUpdatedAt($value)
 */
class SubscriptionSchedule extends Model
{
    //
	protected $hidden = ['pivot'];
}
