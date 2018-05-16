<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	use Illuminate\Notifications\Notifiable;
	
	/**
	 * App\Client
	 *
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bill[]
	 *                        $charges
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Department[]
	 *                        $departments
	 * @property-read mixed
	 *                        $balance
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SubscriptionOptionItem[]
	 *                        $subscriptions
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TopUp[]
	 *                        $topUps
	 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]
	 *                        $users
	 * @mixin \Eloquent
	 * @property int
	 *                   $id
	 * @property string
	 *                   $name
	 * @property string
	 *                   $logo
	 * @property string
	 *                   $email
	 * @property string
	 *                   $phone
	 * @property \Carbon\Carbon|null
	 *                   $created_at
	 * @property \Carbon\Carbon|null
	 *                   $updated_at
	 * @property string|null
	 *                   $deleted_at
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCreatedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereDeletedAt($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereEmail($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereId($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereLogo($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereName($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client wherePhone($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUpdatedAt($value)
	 * @property string
	 *                   $account_type
	 * @property float
	 *                   $limit
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereAccountType($value)
	 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereLimit($value)
	 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
	 *                $notifications
	 */
	class Client extends Model
	{
		use Notifiable, SoftDeletes;
		
		public function subscriptions()
		{
			return $this->hasManyThrough(SubscriptionOptionItem::class, Subscription::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function users()
		{
			return $this->hasMany(User::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function departments()
		{
			return $this->hasMany(Department::class);
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function topUps()
		{
			return $this->hasMany(TopUp::class);
		}
		
		public function bills()
		{
			return $this->hasMany(Bill::class);
		}
		
		
		public function getBalance()
		{
			/**
			 * We find all top up transactions sum them and minus all charges transactions
			 */
			
			$sumTopUps = round($this->topUps()->sum('amount'), 0);
			$sumBills = round($this->bills()->sum('amount'));
			
			return $sumTopUps - $sumBills;
		}
		
		public function getSpent()
		{
			$amountSpent = $this->bills()
				//->whereMonth('created_at', date('m'))
				->whereStatus('SETTLED')
				->sum('amount');
			
			return round($amountSpent, 0);
		}
		
		
		public function getBlocked()
		{
			/**
			 * Return all charges for this month that have status blocking
			 */
			$amountBlocked = $this->bills()
				->whereMonth('created_at', date('m'))
				->whereStatus('BLOCKED')
				->sum('amount');
			
			return round($amountBlocked, 0);
		}
		
		/**
		 * @return bool
		 */
		public function isPostPaid()
		{
			return $this->account_type == 'POST_PAID';
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Model|static|\App\User
		 */
		public function getPurchasingHead()
		{
			return User::whereClientId($this->id)->firstOrFail();
		}
	}
