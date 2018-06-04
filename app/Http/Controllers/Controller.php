<?php
	
	namespace App\Http\Controllers;
	
	use App\Client;
	use App\Exceptions\WrappedException;
	use App\Notifications\BillCanceledNotification;
	use App\Notifications\InsufficientBalance;
	use App\Traits\Billable;
	use App\Utils;
	use Auth;
	use Carbon\Carbon;
	use Closure;
	use Illuminate\Database\Eloquent\Collection;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
	use Illuminate\Foundation\Bus\DispatchesJobs;
	use Illuminate\Foundation\Validation\ValidatesRequests;
	use Illuminate\Http\Request;
	use Illuminate\Routing\Controller as BaseController;
	
	class Controller extends BaseController
	{
		use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
		
		
		/**
		 * @param \Illuminate\Http\Request                     $request
		 * @param \Illuminate\Database\Eloquent\Model|Billable $approval
		 * @param                                              $statusAfterPurchasingHeadApproval
		 * @param \Closure|null                                $afterPurchasingHeadApproval
		 * @throws \App\Exceptions\WrappedException
		 * @throws \Exception
		 */
		public function handleApprovals(Request $request, Model $approval, $statusAfterPurchasingHeadApproval,
		                                Closure $afterPurchasingHeadApproval = null)
		{
			
			$user = Auth::user();
			
			/** @var \App\Bill $bill */
			$bill = $approval->bill()->firstOrFail();
			
			if ($request->action == 'reject') {
				$approval->rejected_by_id = $user->getKey();
				$bill->delete();
			}
			
			//The item was earlier rejected and it is now being approved
			//We have to restore the cancled bill
			else if ($request->action == 'approve' && $approval->status == 'REJECTED' && $approval->rejectedBy->id == $user->id){
				$approval->rejected_by_id = null;
				$bill->restore();
			}
			
			
			//Department head is approving an item for the first time
			if (($approval->status == 'AT_DEPARTMENT_HEAD' && $user->isDepartmentHead())) {
				$approval->status = $request->action == 'approve' ? 'AT_PURCHASING_HEAD' : 'REJECTED';
				$approval->department_head_acted_at = Carbon::now()->toDateTimeString();
				$approval->save();
			}
			
			//Purchasing head is approving an item that has been approved by the department head
			else if (($approval->status == 'AT_PURCHASING_HEAD' && $user->isPurchasingHead())) {
				$approval->status = $request->action == 'approve' ? $statusAfterPurchasingHeadApproval : 'REJECTED';
				$approval->purchasing_head_acted_at = Carbon::now()->toDateTimeString();
				$approval->save();
				if ($afterPurchasingHeadApproval){
					$afterPurchasingHeadApproval($approval);
				}
			}
			
			//Department head is requesting to approve a rejected item
			else if ($request->action == 'approve' && $approval->status == 'REJECTED'
				&& $approval->rejectedBy->id == $user->id && $user->isDepartmentHead()) {
				$approval->status = 'AT_PURCHASING_HEAD';
				$approval->department_head_acted_at = Carbon::now()->toDateTimeString();
				$approval->save();
			}
			
			//Purchasing head is requesting to approve a rejected item
			else if ($request->action == 'approve' && $approval->status == 'REJECTED'
				&& $approval->rejectedBy->id == $user->id && $user->isPurchasingHead()) {
				$approval->status = $statusAfterPurchasingHeadApproval;
				$approval->purchasing_head_acted_at = Carbon::now()->toDateTimeString();
				$approval->save();
			}
			
			//We cannot really tell what is happening
			else {
				throw new WrappedException("You are not allowed to perform the requested operation");
			}
			
			
			//$approval
		}
		
		/**
		 * @throws \App\Exceptions\WrappedException
		 */
		public function checkIfUserIsRider()
		{
			if (!Auth::user()->isRider()) {
				throw new WrappedException('You are not authorized to perform deliveries!');
			}
		}
		
		/**
		 * @throws \App\Exceptions\WrappedException
		 * @return \App\Client
		 * @Deprecated
		 */
		protected function getClient()
		{
			$client = Client::with('users')->find(Auth::user()->client_id);
			if (is_null($client)) {
				throw new WrappedException("Sorry, you are not associated to any client.");
			}
			
			return $client;
		}
		
		/**
		 * @param      $amount
		 * @param null $errorMessage
		 * @throws \App\Exceptions\WrappedException
		 */
		public function checkBalance($amount, $errorMessage = null)
		{
			$client = Auth::user()->getClient();
			
			//In the case of post paid accounts, balance could be -ve
			$balance = $client->getBalance();
			if ($client->isPostPaid()) {
				//Since balance can be negative add the limit to the available balance
				if (($balance + $client->limit) < $amount) {
					$message = is_null($errorMessage) ? 'A request that required ' . Utils::toCurrencyText($amount) . ' could not be completed!' : $errorMessage;
					$client->notify(new InsufficientBalance($message));
					//$client->getPurchasingHead()->notify(new InsufficientBalance($message));
					throw new WrappedException($message);
				}
			} else if ($balance < $amount) {
				if ($balance < $amount) {
					$message = is_null($errorMessage) ? "You have insufficient balance!" : $errorMessage;
					$client->notify(new InsufficientBalance($message));
					//$client->getPurchasingHead()->notify(new InsufficientBalance($message));
					throw new WrappedException($message);
				}
			}
		}
		
		/**
		 * @param Model $item
		 * @param array $meta
		 * @return \Illuminate\Http\Response
		 */
		protected function itemResponse(Model $item, array $meta = ['message' => 'Request successful.'])
		{
			return response()->json(array('meta' => $meta, 'data' => $item));
		}
		
		/**
		 * @param Collection $collection
		 * @param array      $meta
		 * @return \Illuminate\Http\Response
		 */
		protected function collectionResponse(Collection $collection, array $meta = ['message' => 'Request successful.'])
		{
			return response()->json(array('meta' => $meta, 'data' => $collection));
		}
		
		
		/**
		 * @param \Illuminate\Database\Eloquent\Model $item
		 * @param array                               $meta
		 * @return \Illuminate\Http\Response
		 */
		public function itemCreatedResponse(Model $item, array $meta = ['message' => 'Request successful.'])
		{
			return response()->json(array('meta' => $meta, 'data' => $item));
		}
		
		/**
		 * @param \Illuminate\Database\Eloquent\Model $item
		 * @param array                               $meta
		 * @return \Illuminate\Http\Response
		 */
		public function itemUpdatedResponse(Model $item, array $meta = ['message' => 'Request successful.'])
		{
			return response()->json(array('meta' => $meta, 'data' => $item));
		}
		
		/**
		 * @param \Illuminate\Database\Eloquent\Model $item
		 * @param array                               $meta
		 * @return \Illuminate\Http\Response
		 */
		public function itemDeletedResponse(Model $item, array $meta = ['message' => 'Request successful.'])
		{
			return response()->json(array('meta' => $meta, 'data' => $item));
		}
		
		/**
		 * @param array $data
		 * @param array $meta
		 * @return \Illuminate\Http\Response
		 */
		public function arrayResponse(array $data, array $meta = ['message' => 'Request successful.'])
		{
			return response()->json(array('meta' => $meta, 'data' => $data));
		}
	}
