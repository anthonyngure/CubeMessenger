<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ShopOrder
 *
 * @property int $id
 * @property int $client_id
 * @property int $shop_product_id
 * @property int $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\ShopCategory $shopCategory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereShopProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShopOrder extends Model
{
    //
	protected $guarded = ['id', 'created_at', 'updated_at'];
	
	
	protected $hidden = ['shop_product_id', 'client_id'];
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function shopProduct()
	{
		return $this->belongsTo(ShopProduct::class);
	}
}
