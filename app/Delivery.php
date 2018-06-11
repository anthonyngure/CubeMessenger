<?php
	
	namespace App;
	
	use App\Traits\Billable;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\Delivery
 *
 * @property int $id
 * @property int $user_id
 * @property bool $urgent
 * @property string $origin_name
 * @property string $origin_vicinity
 * @property string $origin_formatted_address
 * @property float $origin_latitude
 * @property float                                                             $origin_longitude
 * @property string                                                            $schedule_date
 * @property string                                                            $schedule_time
 * @property float                                                             $estimated_cost
 * @property float                                                             $estimated_max_distance
 * @property float                                                             $estimated_max_duration
 * @property int|null                                                          $rider_id
 * @property string|null                                                       $pickup_time
 * @property float|null                                                        $pickup_latitude
 * @property float|null                                                        $pickup_longitude
 * @property \Carbon\Carbon|null                                               $created_at
 * @property \Carbon\Carbon|null                                               $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bill[]         $charges
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DeliveryItem[] $items
 * @property-read \App\User                                                    $user
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereUrgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereUserId($value)
 * @mixin \Eloquent
 * @property-read mixed                                                        $stats
 * @property-read \App\Bill                                                    $charge
 * @property string|null                                                       $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereDeletedAt($value)
 * @property string $status
 * @property string|null $department_head_acted_at
 * @property string|null $purchasing_head_acted_at
 * @property int|null $rejected_by_id
 * @property-read \App\Bill $bill
 * @property-read \App\User|null $rejectedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereDepartmentHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery wherePurchasingHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereRejectedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Delivery whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery withoutTrashed()
 */
	class Delivery extends Model
	{
		use Billable, SoftDeletes;
		
		protected $appends = ['stats'];
		
		//
		protected $casts = [
			'urgent' => 'boolean',
		];
		
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
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function user()
		{
			return $this->belongsTo(User::class);
		}
		
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function rider()
		{
			return $this->belongsTo(User::class, 'rider_id');
		}
		
		
		public function getStatsAttribute()
		{
			$stats = array();
			$courierOptionGroups = $this->items->groupBy('courier_option_id');
			foreach ($courierOptionGroups as $courierOptionGroup) {
				$totalQuantity = 0;
				foreach ($courierOptionGroup as $courierOptionDeliveryItem) {
					$totalQuantity += $courierOptionDeliveryItem->quantity;
				}
				array_push($stats, [
					'courierOption' => $courierOptionGroup->first()->courierOption,
					'count'         => $totalQuantity,
				]);
			}
			return $stats;
		}
	}
