<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\ShopCategory
 *
 * @property int                 $id
 * @property string              $name
 * @property string|null         $slug
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ShopProduct[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ShopCategory whereOrder($value)
 */
	class ShopCategory extends Model
	{
		//
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function products()
		{
			return $this->hasMany(ShopProduct::class);
		}
	}
