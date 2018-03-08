<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\VerificationMessage
 *
 * @property int $id
 * @property string $number
 * @property string $status
 * @property string $message_id
 * @property string $cost
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VerificationMessage whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VerificationMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VerificationMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VerificationMessage whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VerificationMessage whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VerificationMessage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\VerificationMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class VerificationMessage extends Model
{
    //
	protected $guarded = ['id', 'created_at', 'updated_at'];
}
