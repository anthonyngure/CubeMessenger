<?php
	
	namespace App;
	
	use Illuminate\Notifications\Notifiable;
	use Tymon\JWTAuth\Contracts\JWTSubject;
	
	/**
	 * App\User
	 *
	 * @property int
	 *                   $id
	 * @property int|null
	 *                   $role_id
	 * @property int|null
	 *                   $client_id
	 * @property string
	 *                   $name
	 * @property string
	 *                   $avatar
	 * @property string|null
	 *                   $email
	 * @property string|null
	 *                   $email_verification_code
	 * @property int
	 *                   $email_verified
	 * @property string|null
	 *                   $phone
	 * @property string|null
	 *                   $phone_verification_code
	 * @property int
	 *                   $phone_verified
	 * @property string|null
	 *                   $password
	 * @property string|null
	 *                   $password_recovery_code
	 * @property string
	 *                   $account_type
	 * @property float|null
	 *                   $latitude
	 * @property float|null
	 *                   $longitude
	 * @property string|null
	 *                   $remember_token
	 * @property \Carbon\Carbon|null
	 *                   $created_at
	 * @property \Carbon\Carbon|null
	 *                   $updated_at
	 * @property-read \App\Client|null
	 *                        $client
	 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
	 *                $notifications
	 * @property-read \TCG\Voyager\Models\Role|null
	 *                        $role
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccountType($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereClientId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerificationCode($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerified($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLatitude($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLongitude($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePasswordRecoveryCode($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoneVerificationCode($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoneVerified($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
	 * @mixin \Eloquent
	 */
	class User extends \TCG\Voyager\Models\User implements JWTSubject
	{
		use Notifiable;
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		
		/**
		 * The attributes excluded from the model's JSON form.
		 *
		 * @var array
		 */
		protected $hidden = [
			'role_id',
			'client_id',
			'password',
			'email_verified',
			'phone_verified',
			'password_recovery_code',
			'email_verification_code',
			'phone_verification_code',
			'remember_token',
		];
		
		/**
		 * Get the identifier that will be stored in the subject claim of the JWT.
		 *
		 * @return mixed
		 */
		public function getJWTIdentifier()
		{
			return $this->getKey();
		}
		
		/**
		 * Return a code value array, containing any custom claims to be added to the JWT.
		 *
		 * @return array
		 */
		public function getJWTCustomClaims()
		{
			$date = new \DateTime();
			
			return [
				'id'  => $this->getKey(),
				'iss',
				'iat' => $date->getTimestamp(),
				'exp',
				'nbf',
				'sub' => $this->getKey(),
				'jti',
			];
		}
		
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function client()
		{
			return $this->belongsTo(Client::class);
		}
		
		/**
		 * @return bool
		 */
		public function isClientAdmin()
		{
			return $this->account_type == 'CLIENT_ADMIN';
		}
		
		/**
		 * @return bool
		 */
		public function isPurchasingHead()
		{
			return $this->account_type == 'PURCHASING_HEAD';
		}
		
		/**
		 * @return bool
		 */
		public function isDepartmentHead()
		{
			return $this->account_type == 'DEPARTMENT_HEAD';
		}
	}
