<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AppointmentItem
 *
 * @property int $id
 * @property int $appointment_id
 * @property string $details
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentItem whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentItem whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppointmentItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppointmentItem extends Model
{
    //
	protected $guarded = [
		'id', 'created_at', 'updated_at',
	];
	
	protected $hidden = [
		'appointment_id',
	];
}
