<?php
	
	namespace App;
	
	use App\Traits\Billable;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\ShopOrder
 *
 * @property int                                                            $id
 * @property int                                                            $user_id
 * @property string                                                         $status
 * @property int|null                                                       $rejected_by_id
 * @property string|null                                                    $department_head_acted_at
 * @property string|null                                                    $purchasing_head_acted_at
 * @property string|null                                                    $delivered_at
 * @property \Carbon\Carbon|null                                            $created_at
 * @property \Carbon\Carbon|null                                            $updated_at
 * @property string|null                                                    $deleted_at
 * @property-read \App\Bill                                                 $bill
 * @property-read int                                                       $amount
 * @property-read int                                                       $item_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OrderItem[] $items
 * @property-read \App\User|null                                            $rejectedBy
 * @property-read \App\User                                                 $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Order onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDepartmentHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePurchasingHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereRejectedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Order withoutTrashed()
 * @mixin \Eloquent
 */
	class Order extends Model
	{
		//
		protected $appends = ['itemCount', 'amount'];
		use SoftDeletes, Billable;
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		
		protected $hidden = ['user_id'];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function items()
		{
			return $this->hasMany(OrderItem::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function user()
		{
			return $this->belongsTo(User::class);
		}
		
		/**
		 * @return int
		 */
		public function getAmountAttribute()
		{
			return Utils::toCurrencyText($this->items->sum(function (OrderItem $item) {
				return ($item->price_at_purchase * $item->quantity);
			}));
		}
		
		/**
		 * @return int
		 */
		public function getItemCountAttribute()
		{
			return $this->items->count();
		}
		
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function rejectedBy()
		{
			return $this->belongsTo(User::class, 'rejected_by_id');
		}
		
	}
