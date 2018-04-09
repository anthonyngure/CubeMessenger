<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\Charge
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $chargeable
 * @mixin \Eloquent
 * @property int $id
 * @property int $client_id
 * @property int $chargeable_id
 * @property string $chargeable_type
 * @property float $amount
 * @property int $settled
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charge whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charge whereChargeableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charge whereChargeableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charge whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charge whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charge whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charge whereSettled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Charge whereUpdatedAt($value)
 */
	class Charge extends Model
	{
		//
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
		 */
		public function chargeable()
		{
			return $this->morphTo();
		}
		
	}
