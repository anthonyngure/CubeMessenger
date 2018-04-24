<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\CourierOption
 *
 * @property int $id
 * @property string $name
 * @property string $plural_name
 * @property string $icon
 * @property bool $active
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption wherePluralName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CourierOption whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class CourierOption extends Model
	{
		
		protected $casts = [
			'active' => 'boolean',
		];
		
		protected $hidden = [
			'created_at', 'updated_at',
		];
	}
