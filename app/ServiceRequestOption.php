<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\ServiceRequestOption
 *
 * @property int                 $id
 * @property string              $type
 * @property string              $name
 * @property string              $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestOption whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceRequestOption onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceRequestOption withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceRequestOption withoutTrashed()
 */
	class ServiceRequestOption extends Model
	{
		//
		use SoftDeletes;
		protected $guarded = ['id', 'created_at', 'updated_at'];
	}
