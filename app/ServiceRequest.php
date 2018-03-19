<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Service
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $client_id
 * @property int $service_request_option_id
 * @property int|null $assigned_to
 * @property string $status
 * @property string $note
 * @property float $cost
 * @property string $scheduled_date
 * @property string $scheduled_time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereScheduledDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereScheduledTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereServiceRequestOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ServiceRequest whereStatus($value)
 */
class ServiceRequest extends Model
{
    //
	protected $guarded = ['id', 'created_at', 'updated_at'];
}
