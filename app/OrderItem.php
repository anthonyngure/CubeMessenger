<?php

namespace App;

use App\Traits\Billable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\OrderProduct
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $quantity
 * @property float $price_at_purchase
 * @property float $amount
 * @property string $status
 * @property int|null $rejected_by_id
 * @property string|null $department_head_acted_at
 * @property string|null $purchasing_head_acted_at
 * @property string|null $delivered_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\OrderItem onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereDepartmentHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem wherePriceAtPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem wherePurchasingHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereRejectedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\OrderItem withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Product $product
 * @property-read \App\User $rejectedBy
 */
class OrderItem extends Model
{
    //
	use SoftDeletes;
	
	protected $hidden = ['rejected_by_id'];
	
	protected $guarded = ['id'];
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
