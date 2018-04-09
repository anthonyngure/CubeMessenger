<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\ShopOrder
 *
 * @property int                    $id
 * @property int                    $client_id
 * @property int                    $shop_product_id
 * @property int                    $quantity
 * @property \Carbon\Carbon|null    $created_at
 * @property \Carbon\Carbon|null    $updated_at
 * @property-read \App\ShopCategory $shopCategory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereShopProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $status
 * @property string|null $department_head_approved_at
 * @property string|null $purchasing_head_approved_at
 * @property string|null $delivered_at
 * @property-read \App\ShopProduct $shopProduct
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereDepartmentHeadApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder wherePurchasingHeadApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereStatus($value)
 * @property int $user_id
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereUserId($value)
 * @property int|null $rejected_by_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereRejectedById($value)
 * @property-read \App\User|null $rejectedBy
 */
	class ShopOrder extends Model
	{
		//
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		
		protected $hidden = ['shop_product_id', 'client_id', 'user_id'];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function shopProduct()
		{
			return $this->belongsTo(ShopProduct::class);
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
		public function rejectedBy()
		{
			return $this->belongsTo(User::class, 'rejected_by_id');
		}
	}
