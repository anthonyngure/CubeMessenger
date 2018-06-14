<?php
	
	namespace App;
	
	use App\Exceptions\WrappedException;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	use Illuminate\Notifications\Notifiable;
	
	/**
	 * App\DeliveryItem
	 *
	 * @property int                     $id
	 * @property int                     $courier_option_id
	 * @property int                     $delivery_id
	 * @property string                  $destination_name
	 * @property string                  $destination_vicinity
	 * @property string                  $destination_formatted_address
	 * @property float                   $destination_latitude
	 * @property float                   $destination_longitude
	 * @property string                  $recipient_name
	 * @property string                  $recipient_contact
	 * @property int                     $quantity
	 * @property string|null             $note
	 * @property float                   $estimated_distance
	 * @property float                   $estimated_duration
	 * @property string                  $status
	 * @property int|null                $rejected_by_id
	 * @property string|null             $estimated_arrival_time
	 * @property int|null                $received_confirmation_code
	 * @property string|null             $received_time
	 * @property float|null              $received_latitude
	 * @property float|null              $received_longitude
	 * @property \Carbon\Carbon|null     $created_at
	 * @property \Carbon\Carbon|null     $updated_at
	 * @property-read \App\CourierOption $courierOption
	 * @property-read \App\Delivery      $delivery
	 * @property-read \App\User|null     $rejectedBy
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereCourierOptionId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereDeliveryId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereDestinationFormattedAddress($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereDestinationLatitude($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereDestinationLongitude($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereDestinationName($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereDestinationVicinity($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereEstimatedArrivalTime($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereEstimatedDistance($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereEstimatedDuration($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereNote($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereQuantity($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereReceivedConfirmationCode($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereReceivedLatitude($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereReceivedLongitude($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereReceivedTime($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereRecipientContact($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereRecipientName($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereRejectedById($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereStatus($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereUpdatedAt($value)
	 * @mixin \Eloquent
	 * @property string|null             $department_head_acted_at
	 * @property string|null             $purchasing_head_acted_at
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereDepartmentHeadActedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem wherePurchasingHeadActedAt($value)
	 * @property string|null             $deleted_at
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\DeliveryItem whereDeletedAt($value)
	 * @property-read \App\Bill          $bill
	 * @method static bool|null forceDelete()
	 * @method static \Illuminate\Database\Query\Builder|\App\DeliveryItem onlyTrashed()
	 * @method static bool|null restore()
	 * @method static \Illuminate\Database\Query\Builder|\App\DeliveryItem withTrashed()
	 * @method static \Illuminate\Database\Query\Builder|\App\DeliveryItem withoutTrashed()
	 */
	class DeliveryItem extends Model
	{
		//
		use SoftDeletes, Notifiable;
		protected $casts = [
			'with_return' => 'boolean',
		];
		protected $guarded = [
			'id', 'created_at', 'updated_at',
		];
		
		protected $hidden = [
			'courier_option_id', 'delivery_id', 'received_confirmation_code',
		];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function courierOption()
		{
			return $this->belongsTo(CourierOption::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function delivery()
		{
			return $this->belongsTo(Delivery::class);
		}
		
		/**
		 * @throws \App\Exceptions\WrappedException
		 */
		public function checkEnRouteRoDestination()
		{
			if ($this->status != 'EN_ROUTE_TO_DESTINATION') {
				throw new WrappedException("Delivery item is not on its way to destination");
			}
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\MorphOne
		 */
		public function bill()
		{
			return $this->morphOne(Bill::class, 'billable');
		}
		
		public function routeNotificationForSMS()
		{
			return $this->recipient_contact;
		}
	}
