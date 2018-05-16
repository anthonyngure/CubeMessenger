<?php
	
	namespace App;
	
	use App\Traits\Billable;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
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
 * @property string|null $department_head_acted_at
 * @property string|null $purchasing_head_acted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereDepartmentHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder wherePurchasingHeadActedAt($value)
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereDeletedAt($value)
 */
	class ShopOrder extends Model
	{
		//
		
		use SoftDeletes, Billable;
		
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
		
	}
