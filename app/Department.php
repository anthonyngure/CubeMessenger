<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\Department
 *
 * @property int                                                       $id
 * @property int                                                       $client_id
 * @property string                                                    $name
 * @property float                                                     $allocated_budget
 * @property \Carbon\Carbon|null                                       $created_at
 * @property \Carbon\Carbon|null                                       $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereAllocatedBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Department onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Department withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Department withoutTrashed()
 */
	class Department extends Model
	{
		//
		use SoftDeletes;
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function users()
		{
			return $this->hasMany(User::class);
		}
	}
