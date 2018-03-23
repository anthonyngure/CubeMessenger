<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
	 * App\ShopProduct
	 *
	 * @property int                    $id
	 * @property int                    $shop_category_id
	 * @property string                 $name
	 * @property string                 $image
	 * @property string|null            $slug
	 * @property float                  $price
	 * @property float                  $old_price
	 * @property string                 $description
	 * @property \Carbon\Carbon|null    $created_at
	 * @property \Carbon\Carbon|null    $updated_at
	 * @property-read \App\ShopCategory $category
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopProduct whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopProduct whereDescription($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopProduct whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopProduct whereImage($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopProduct whereName($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopProduct whereOldPrice($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopProduct wherePrice($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopProduct whereShopCategoryId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopProduct whereSlug($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopProduct whereUpdatedAt($value)
	 * @mixin \Eloquent
	 */
	class ShopProduct extends Model
	{
		//
		
		protected $hidden = ['shop_category_id'];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function category()
		{
			return $this->belongsTo(ShopCategory::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasOne
		 */
		public function clientOrder()
		{
			return $this->hasOne(ShopOrder::class);
		}
	}