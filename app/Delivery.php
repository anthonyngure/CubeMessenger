<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\Delivery
 *
 * @property int                                                               $id
 * @property int                                                               $client_id
 * @property string                                                            $origin_name
 * @property string                                                            $origin_vicinity
 * @property string                                                            $origin_formatted_address
 * @property float                                                             $origin_latitude
 * @property float                                                             $origin_longitude
 * @property string                                                            $schedule_date
 * @property string                                                            $schedule_time
 * @property float                                                             $estimated_cost
 * @property float                                                             $estimated_max_distance
 * @property float                                                             $estimated_max_duration
 * @property float                                                             $actual_cost
 * @property int                                                               $rider_id
 * @property string|null                                                       $pickup_time
 * @property float|null                                                        $pickup_latitude
 * @property float|null                                                        $pickup_longitude
 * @property \Carbon\Carbon|null                                               $created_at
 * @property \Carbon\Carbon|null                                               $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DeliveryItem[] $items
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereActualCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereEstimatedCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereEstimatedMaxDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereEstimatedMaxDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereOriginFormattedAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereOriginLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereOriginLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereOriginName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereOriginVicinity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery wherePickupLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery wherePickupLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery wherePickupTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereRiderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereScheduleDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereScheduleTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Client $client
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereUserId($value)
 */
	class Delivery extends Model
	{
		//
		
		protected $guarded = [
			'id', 'created_at', 'updated_at',
		];
		
		protected $hidden = [
			'client_id',
		];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function items()
		{
			return $this->hasMany(DeliveryItem::class);
		}
		
		public function client()
		{
			return $this->belongsTo(Client::class);
		}
	}
