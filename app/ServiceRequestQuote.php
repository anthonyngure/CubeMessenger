<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\ServiceRequestQuote
 *
 * @property int                 $id
 * @property int                 $service_request_id
 * @property string|null         $note
 * @property float               $diagnosis_cost
 * @property float               $labour_cost
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestQuote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestQuote whereDiagnosisCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestQuote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestQuote whereLabourCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestQuote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestQuote whereServiceRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequestQuote whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServiceRequestItem[] $items
 */
	class ServiceRequestQuote extends Model
	{
		//
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		protected $hidden = ['service_request_id'];
		
		public function items()
		{
			return $this->hasMany(ServiceRequestItem::class, 'service_request_quote_id');
		}
	}
