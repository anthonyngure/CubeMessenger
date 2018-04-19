<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AppointmentExternalParticipant
 *
 * @property int $id
 * @property int $appointment_id
 * @property string $email
 * @property string $phone
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentExternalParticipant whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentExternalParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentExternalParticipant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentExternalParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentExternalParticipant wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentExternalParticipant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppointmentExternalParticipant extends Model
{
    //
	
	protected $guarded = [
		'id', 'created_at', 'updated_at',
	];
	
	protected $hidden = [
		'appointment_id',
	];
}