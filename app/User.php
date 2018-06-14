<?php
	
	namespace App;
	
	use App\Exceptions\WrappedException;
	use Illuminate\Database\Eloquent\SoftDeletes;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;
	use Tymon\JWTAuth\Contracts\JWTSubject;
	
	/**
	 * App\User
	 */
	class User extends Authenticatable implements JWTSubject
	{
		use Notifiable, SoftDeletes;
		
		//protected $appends = ['role'];
		
		protected $guarded = ['id', 'created_at', 'updated_at'];
		private $lazyLoadedClient = null;
		
		/**
		 * The attributes excluded from the model's JSON form.
		 *
		 * @var array
		 */
		protected $hidden = [
			'role_id',
			'department_id',
			'client_id',
			'password',
			'email_verified',
			'phone_verified',
			'password_recovery_code',
			'email_verification_code',
			'phone_verification_code',
			'remember_token',
			'pivot',
		];
		
		public static function loadableRelations()
		{
			return ['role', 'client', 'department'];
		}
		
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
		
		
		public function routeNotificationForSMSChannel()
		{
			return $this->phone;
			//return '0740665211';
		}
		
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function client()
		{
			
			return $this->belongsTo(Client::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function department()
		{
			return $this->belongsTo(Department::class);
		}
		
		
		/**
		 * @return bool
		 */
		public function isClientAdmin()
		{
			return $this->role->name == 'CLIENT_ADMIN';
		}
		
		public function isSupplier()
		{
			return $this->role->name == 'SUPPLIER';
		}
		
		/**
		 * @return \App\Client
		 * @throws \App\Exceptions\WrappedException
		 */
		public function getClient()
		{
			if (!$this->lazyLoadedClient) {
				/** @var \App\Client $client */
				$this->lazyLoadedClient = Client::with('users')->find($this->client_id);
				if (is_null($this->lazyLoadedClient)) {
					throw new WrappedException("Sorry, you are not associated to any client.");
				}
			}
			
			return $this->lazyLoadedClient;
		}
		
		/**
		 * @return bool
		 */
		public function isPurchasingHead()
		{
			return $this->role->name == 'PURCHASING_HEAD';
		}
		
		/**
		 * @return bool
		 */
		public function isDepartmentHead()
		{
			return $this->role->name == 'DEPARTMENT_HEAD';
		}
		
		/**
		 * @return bool
		 */
		public function isRider()
		{
			return $this->role->name == 'RIDER';
		}
		
		/**
		 * @return bool
		 */
		public function isAdmin()
		{
			return $this->role->name == 'ADMIN';
		}
		
		public function isOperations()
		{
			return $this->role->name == 'OPERATIONS';
		}
		
		/*public function getRoleAttribute()
		{
			return $this->role->name;
		}*/
		
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function serviceRequests()
		{
			return $this->hasMany(ServiceRequest::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
		 */
		public function appointments()
		{
			return $this->belongsToMany(Appointment::class, 'appointment_internal_participants');
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function deliveries()
		{
			return $this->hasMany(Delivery::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function orders()
		{
			return $this->hasMany(Order::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function role()
		{
			return $this->belongsTo(Role::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function products()
		{
			return $this->hasMany(Product::class, 'supplier_id');
		}
		
	}
