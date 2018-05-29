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
 * @method static \Illuminate\Database\Query\Builder|\App\OrderProduct onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereDeliveredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereDepartmentHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct wherePriceAtPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct wherePurchasingHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereRejectedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OrderProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\OrderProduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\OrderProduct withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Product $product
 */
class OrderProduct extends Model
{
    //
	use SoftDeletes;
	
	protected $guarded = ['id'];
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
