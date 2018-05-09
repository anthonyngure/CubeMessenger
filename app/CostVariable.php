<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\SystemVariable
 *
 * @property int $id
 * @property string $name
 * @property float $value
 * @property string|null $options
 * @property int $public
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CostVariable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CostVariable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CostVariable whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CostVariable whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CostVariable wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CostVariable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CostVariable whereValue($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CostVariable whereDeletedAt($value)
 */
	class CostVariable extends Model
	{
		//
		
		protected $casts = [
			'value' => 'float',
		];
		
		protected $hidden = ['created_at', 'updated_at', 'public'];
	}
