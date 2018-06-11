<?php
	
	namespace App;
	
	use App\Mail\ScheduleExecution;
	use App\Notifications\AppointmentNotification;
	use App\Notifications\LPONotification;
	use Carbon\Carbon;
	use Illuminate\Database\Eloquent\Builder;
	
	class ScheduledTasksManager
	{
		//
		
		public static function sendScheduleExecutionEmail($message)
		{
			\Mail::send(new ScheduleExecution($message));
		}
		
		public static function sendLPO()
		{
			$suppliers = User::whereHas('role', function (Builder $builder) {
				return $builder->where('name', 'SUPPLIER');
			})->get();
			
			/** @var \App\User $supplier */
			foreach ($suppliers as $supplier) {
				//Get supplier products
				$products = $supplier->products()->get();
				//dd($products->pluck('id'));
				//Get order items with this supplier products
				$orderItems = OrderItem::whereStatus('PENDING_LPO')->whereIn('product_id', $products->pluck('id'))->get();
				//dd($orderItems->count());
				//Group the orderItems by product id
				$orderItemsGroupedByProductId = $orderItems->groupBy('product_id');
				//dd($orderItemsGroupedByProductId->count());
				$LPOItems = array();
				foreach ($orderItemsGroupedByProductId as $key => $orderItemsProductGroup) {
					
					//dd($orderItemsProductGroup);
					
					//Key is the product Id
					//Sum the total quantity we need for this product from this supplier
					//To make an LPO Item
					/** @var \App\Product $product */
					$product = Product::findOrFail($key);
					array_push($LPOItems, [
						'item'     => $product->name,
						'quantity' => collect($orderItemsProductGroup)->sum('quantity'),
					]);
					
					//Update order items in this product group to status SENT_LPO
					/** @var OrderItem $orderItem */
					foreach ($orderItemsProductGroup as $orderItem) {
						$orderItem->update(['status' => 'SENT_LPO']);
					}
					
				}
				
				if (count($LPOItems) > 0) {
					
					$supplier->notify(new LPONotification($LPOItems, $supplier));
				}
				
			}
		}
		
		public static function sendAppointmentsNotifications()
		{
			$appointments = Appointment::with(['internalParticipants', 'externalParticipants'])
				->whereDate('starting_at', '=', Carbon::today()->toDateString())
				->whereBetween('starting_at', [now()->subMinute()->toDateTimeString(),
					now()->addMinutes(30)->toDateTimeString()])->get();
			
			/** @var \App\Appointment $appointment */
			foreach ($appointments as $appointment) {
				foreach ($appointment->internalParticipants as $internalParticipant) {
					$internalParticipant->notify(new AppointmentNotification($appointment));
				}
				
				foreach ($appointment->externalParticipants as $externalParticipant) {
					$externalParticipant->notify(new AppointmentNotification($appointment));
				}
			}
			//dd($appointments->getBindings());
			//dd($appointments->count());
		}
	}
