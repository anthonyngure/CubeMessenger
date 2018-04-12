<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	/**
 * App\Client
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Charge[]                 $charges
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Department[]             $departments
 * @property-read mixed                                                                  $balance
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SubscriptionOptionItem[] $subscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TopUp[]                  $topUps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[]                   $users
 * @mixin \Eloquent
 * @property int                                                                         $id
 * @property string                                                                      $name
 * @property string                                                                      $logo
 * @property string                                                                      $email
 * @property string                                                                      $phone
 * @property \Carbon\Carbon|null                                                         $created_at
 * @property \Carbon\Carbon|null                                                         $updated_at
 * @property string|null                                                                 $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereUpdatedAt($value)
 * @property string $account_type
 * @property float $limit
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Client whereLimit($value)
 */
	class Client extends Model
	{
		
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
		
		public function charges()
		{
			return $this->hasMany(Charge::class);
		}
		
		
		public function getBalance()
		{
			/**
			 * We find all top up transactions sum them and minus all charges transactions
			 */
			
			$sumTopUps = $this->topUps()->sum('amount');
			$sumCharges = $this->charges()->sum('amount');
			
			return $sumTopUps - $sumCharges;
		}
	}
