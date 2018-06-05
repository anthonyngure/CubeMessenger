<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

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
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentExternalParticipant whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\AppointmentExternalParticipant onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\AppointmentExternalParticipant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\AppointmentExternalParticipant withoutTrashed()
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 */
class AppointmentExternalParticipant extends Model
{
    //
	
	use SoftDeletes, Notifiable;
	
	protected $guarded = [
		'id', 'created_at', 'updated_at',
	];
	
	protected $hidden = [
		'appointment_id',
	];
}
