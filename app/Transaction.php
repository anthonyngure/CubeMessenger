<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Transaction
 *
 * @property int $id
 * @property int $client_id
 * @property int|null $user_id
 * @property float $amount
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereUserId($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    //
}
