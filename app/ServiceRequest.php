<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\Service
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $assigned_to
 * @property string $type
 * @property string $status
 * @property int|null $rejected_by_id
 * @property string $details
 * @property string|null $note
 * @property string|null $schedule_date
 * @property string|null $schedule_time
 * @property string|null $department_head_acted_at
 * @property string|null $purchasing_head_acted_at
 * @property string|null $attended_at
 * @property string|null $completed_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\ServiceRequestQuote $quote
 * @property-read \App\User|null $rejectedBy
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereAttendedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereDepartmentHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest wherePurchasingHeadActedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereRejectedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereScheduleDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereScheduleTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereUserId($value)
 * @mixin \Eloquent
 */
	class ServiceRequest extends Model
	{
		//
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		protected $hidden = ['user_id', 'assigned_to', 'rejected_by_id'];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function rejectedBy()
		{
			return $this->belongsTo(User::class, 'rejected_by_id');
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasOne
		 */
		public function quote()
		{
			return $this->hasOne(ServiceRequestQuote::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function user()
		{
			return $this->belongsTo(User::class);
		}
	}
