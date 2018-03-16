<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SmsMessage
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $status
 * @property string $message_id
 * @property string $destination
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SmsMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SmsMessage whereDestination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SmsMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SmsMessage whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SmsMessage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SmsMessage whereUpdatedAt($value)
 */
class SmsMessage extends Model
{
    //
	protected $guarded = ['id', 'created_at', 'updated_at'];
}
