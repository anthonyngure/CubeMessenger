<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\SupplierProduct
 *
 * @property int $user_id
 * @property int $product_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\SupplierProduct onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SupplierProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SupplierProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SupplierProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SupplierProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SupplierProduct whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SupplierProduct withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SupplierProduct withoutTrashed()
 * @mixin \Eloquent
 */
class SupplierProduct extends Model
	{
		//
		use SoftDeletes;
		protected $guarded = ['id', 'created_at', 'updated_at'];
		protected $hidden = ['deleted_at'];
	}
