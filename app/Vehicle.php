<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\VehicleModel
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $year
 * @property string $make
 * @property string $model
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereMake($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Vehicle whereYear($value)
 */
class Vehicle extends Model
{
    //
}
