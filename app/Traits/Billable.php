<?php
	/**
	 * Created by PhpStorm.
	 * User: Tosh
	 * Date: 15/05/2018
	 * Time: 14:51
	 */
	
	namespace App\Traits;
	
	
	use App\Bill;
	use App\User;
	
	trait Billable
	{
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\MorphOne
		 */
		public function bill()
		{
			return $this->morphOne(Bill::class, 'billable');
		}
		
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function rejectedBy()
		{
			return $this->belongsTo(User::class, 'rejected_by_id');
		}
	}