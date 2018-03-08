<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CourierOption
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property float $base_cost
 * @property float $cost_per_minute
 * @property float $cost_per_kilometer
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereBaseCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereCostPerKilometer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereCostPerMinute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereUpdatedAt($value)
 * @property string $icon
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereIcon($value)
 * @property string $plural_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption wherePluralName($value)
 */
class CourierOption extends Model
{
    //
	protected $hidden = [
		'created_at', 'updated_at',
	];
}
