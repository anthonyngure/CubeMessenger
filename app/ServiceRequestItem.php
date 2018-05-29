<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\ServiceRequestItem
 *
 * @property int                 $id
 * @property int                 $service_request_quote_id
 * @property string              $name
 * @property float               $price
 * @property string|null         $note
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestItem whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestItem whereServiceRequestQuoteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestItem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestItem whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceRequestItem onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceRequestItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ServiceRequestItem withoutTrashed()
 */
	class ServiceRequestItem extends Model
	{
		//
		
		use SoftDeletes;
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		protected $hidden = ['service_request_quote_id'];
	}
