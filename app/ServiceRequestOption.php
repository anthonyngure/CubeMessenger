<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\ServiceRequestOption
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceRequestOption extends Model
	{
		//
		protected $guarded = ['id', 'created_at', 'updated_at'];
	}
