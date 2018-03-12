<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SmsMessage
 *
 * @mixin \Eloquent
 */
class SmsMessage extends Model
{
    //
	protected $guarded = ['id', 'created_at', 'updated_at'];
}
