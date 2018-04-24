<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
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
 */
	class ServiceRequestItem extends Model
	{
		//
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		protected $hidden = ['service_request_quote_id'];
	}
