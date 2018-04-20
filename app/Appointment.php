<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
	 * App\Appointment
	 *
	 * @property int                                                                                 $id
	 * @property string                                                                              $start_date
	 * @property string|null                                                                         $start_time
	 * @property string                                                                              $end_date
	 * @property string|null                                                                         $end_time
	 * @property int                                                                                 $user_id
	 * @property string                                                                              $venue
	 * @property string                                                                              $title
	 * @property int                                                                                 $all_day
	 * @property \Carbon\Carbon|null                                                                 $created_at
	 * @property \Carbon\Carbon|null                                                                 $updated_at
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereAllDay($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereEndDate($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereEndTime($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereStartDate($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereStartTime($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereTitle($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereUpdatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereUserId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereVenue($value)
	 * @mixin \Eloquent
	 * @property int                                                                                 $client_id
	 * @property int                                                                                 $with_id
	 * @property string|null                                                                         $note
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AppointmentInternalParticipant[] $participants
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereClientId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereNote($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Appointment whereWithId($value)
	 * @property-read \App\User                                                                      $user
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AppointmentExternalParticipant[]
	 *                $externalParticipants
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AppointmentInternalParticipant[]
	 *                $internalParticipants
	 */
	class Appointment extends Model
	{
		
		protected $casts = [
			'all_day' => 'boolean',
		];
		
		//
		protected $guarded = [
			'id', 'created_at', 'updated_at',
		];
		
		protected $hidden = [
			'user_id',
			'pivot'
		];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
		 */
		public function internalParticipants()
		{
			return $this->belongsToMany(User::class, "appointment_internal_participants");
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function externalParticipants()
		{
			return $this->hasMany(AppointmentExternalParticipant::class);
		}
		
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function items()
		{
			return $this->hasMany(AppointmentItem::class);
		}
		
		
	}
