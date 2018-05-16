<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\TopUp
 *
 * @property-read \App\Client $client
 * @mixin \Eloquent
 * @property int $id
 * @property int $client_id
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopUp whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopUp whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopUp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopUp whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopUp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TopUp whereUpdatedAt($value)
 */
	class TopUp extends Model
	{
		//
		
		use SoftDeletes;
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function client()
		{
			return $this->belongsTo(Client::class);
		}
		
		
	}
