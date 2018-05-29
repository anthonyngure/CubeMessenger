<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\Charge
 *
 * @property int $id
 * @property int $client_id
 * @property int $billable_id
 * @property string $billable_type
 * @property float $amount
 * @property string $status
 * @property string $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $chargeable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereChargeableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereChargeableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $billable
 * @property-read \App\Client $client
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Bill onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereBillableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bill whereBillableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bill withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Bill withoutTrashed()
 */
	class Bill extends Model
	{
		//
		
		use SoftDeletes;
		
		protected $casts = [
			'amount'      => 'float',
			'description' => 'string',
		];
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		protected $hidden = [
			'billable_id', 'billable_type', 'client_id',
		];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
		 */
		public function billable()
		{
			return $this->morphTo();
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function client()
		{
			return $this->belongsTo(Client::class);
		}
		
	}
