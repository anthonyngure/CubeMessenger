<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
	 * App\AppointmentParticipant
	 *
	 * @property int                 $id
	 * @property int                 $appointment_id
	 * @property string              $email
	 * @property string              $phone
	 * @property \Carbon\Carbon|null $created_at
	 * @property \Carbon\Carbon|null $updated_at
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentParticipant whereAppointmentId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentParticipant whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentParticipant whereEmail($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentParticipant whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentParticipant wherePhone($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentParticipant whereUpdatedAt($value)
	 * @mixin \Eloquent
	 */
	class AppointmentParticipant extends Model
	{
		//
		
		protected $guarded = [
			'id', 'created_at', 'updated_at',
		];
		
		protected $hidden = [
			'appointment_id',
		];
	}
