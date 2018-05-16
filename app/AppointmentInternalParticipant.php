<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\AppointmentParticipant
 *
 * @property int                 $id
 * @property int                 $appointment_id
 * @property string              $email
 * @property string              $phone
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentInternalParticipant whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentInternalParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentInternalParticipant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentInternalParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentInternalParticipant wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentInternalParticipant whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentInternalParticipant whereUserId($value)
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentInternalParticipant whereDeletedAt($value)
 */
	class AppointmentInternalParticipant extends Model
	{
		//
		use SoftDeletes;
		
		protected $guarded = [
			'id', 'created_at', 'updated_at','pivot'
		];
		
		protected $hidden = [
			'appointment_id',
		];
	}
