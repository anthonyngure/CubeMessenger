<?php
	
	namespace App;
	
	use App\Traits\Billable;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\ShopOrder
 *
 * @property int                                                          $id
 * @property int                                                          $client_id
 * @property int                                                          $shop_product_id
 * @property int                                                          $quantity
 * @property \Carbon\Carbon|null                                          $created_at
 * @property \Carbon\Carbon|null                                          $updated_at
 * @property-read \App\Category                                           $shopCategory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereShopProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string                                                       $status
 * @property string|null                                                  $department_head_approved_at
 * @property string|null                                                  $purchasing_head_approved_at
 * @property string|null                                                  $delivered_at
 * @property-read \App\Product                                            $shopProduct
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDepartmentHeadApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePurchasingHeadApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStatus($value)
 * @property int                                                          $user_id
 * @property-read \App\User                                               $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @property int|null                                                     $rejected_by_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereRejectedById($value)
 * @property-read \App\User|null                                          $rejectedBy
 * @property string|null                                                  $department_head_acted_at
 * @property string|null                                                  $purchasing_head_acted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDepartmentHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePurchasingHeadActedAt($value)
 * @property string|null                                                  $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeletedAt($value)
 * @property-read \App\Bill                                               $bill
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Order onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Order withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @property-read int $amount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OrderProduct[] $items
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
			return $this->hasMany(OrderProduct::class);
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
			return Utils::toCurrencyText($this->items->sum('amount'));
		}
		
		/**
		 * @return int
		 */
		public function getItemCountAttribute()
		{
			return $this->items->count();
		}
		
	}
