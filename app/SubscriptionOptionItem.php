<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	
	/**
 * App\SubscriptionItem
 *
 * @property int                    $id
 * @property string                 $name
 * @property int|null               $subscription_type_id
 * @property int                    $item_cost Current retail price of the item
 * @property \Carbon\Carbon|null    $created_at
 * @property \Carbon\Carbon|null    $updated_at
 * @property-read \App\Subscription $clientSubscription
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionOptionItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionOptionItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionOptionItem whereItemCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionOptionItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionOptionItem whereSubscriptionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionOptionItem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null               $subscription_option_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionOptionItem
 *         whereSubscriptionOptionId($value)
 * @property int                    $price     Current retail price of the item
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionOptionItem wherePrice($value)
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SubscriptionOptionItem whereDeletedAt($value)
 */
	class SubscriptionOptionItem extends Model
	{
		
		use SoftDeletes;
		
		protected $hidden = ['option_id', 'created_at', 'updated_at'];
		
	}
