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
	use Fractal;
	use Illuminate\Database\Eloquent\Collection;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
	use Illuminate\Foundation\Bus\DispatchesJobs;
	use Illuminate\Foundation\Validation\ValidatesRequests;
	use Illuminate\Http\Request;
	use Illuminate\Routing\Controller as BaseController;
	use League\Fractal\TransformerAbstract;
	
	class Controller extends BaseController
	{
		use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
		
		
		/**
		 * @param \Illuminate\Http\Request                     $request
		 * @param \Illuminate\Database\Eloquent\Model|Billable $approval
		 * @throws \App\Exceptions\WrappedException
		 * @throws \Exception
		 */
		public function handleApprovals(Request $request, Model $approval, $statusAfterPurchasingHeadApproval)
		{
			
			$user = Auth::user();
			if ($request->action == 'reject') {
				$approval->rejected_by_id = $user->getKey();
				/** @var \App\Bill $bill */
				$bill = $approval->bill()->firstOrFail();
				$bill->delete();
				/** @var \App\Client $client */
				$client = $bill->client()->firstOrFail();
				$client->notify(new BillCanceledNotification($bill));
			}
			
			if (($approval->status == 'AT_DEPARTMENT_HEAD' && $user->isDepartmentHead())) {
				$approval->status = $request->action == 'approve' ? 'AT_PURCHASING_HEAD' : 'REJECTED';
				$approval->department_head_acted_at = Carbon::now()->toDateTimeString();
				$approval->save();
			} else if (($approval->status == 'AT_PURCHASING_HEAD' && $user->isPurchasingHead())) {
				$approval->status = $request->action == 'approve' ? $statusAfterPurchasingHeadApproval : 'REJECTED';
				$approval->purchasing_head_acted_at = Carbon::now()->toDateTimeString();
				$approval->save();
			} else {
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
		 * @param Model               $item
		 * @param TransformerAbstract $transformer
		 * @param array               $meta
		 * @return \Illuminate\Http\Response
		 */
		protected function itemResponse(Model $item, TransformerAbstract $transformer = null, array $meta = ['message' => 'Request successful.'])
		{
			if (!is_null($transformer)) {
				
				$data = Fractal::item($item, $transformer)->toArray();
				
				return response()->json(array('meta' => $meta, 'data' => $data['data']), 200);
			} else {
				
				return response()->json(array('meta' => $meta, 'data' => $item), 200);
			}
		}
		
		/**
		 * @param Collection          $collection
		 * @param TransformerAbstract $transformer
		 * @param array               $meta
		 * @return \Illuminate\Http\Response
		 */
		protected function collectionResponse(Collection $collection, TransformerAbstract $transformer = null,
		                                      array $meta = ['message' => 'Request successful.'])
		{
			if (!is_null($transformer)) {
				$data = Fractal::collection($collection, $transformer)->toArray();
				
				return response()->json(array('meta' => $meta, 'data' => $data['data']), 200);
			} else {
				return response()->json(array('meta' => $meta, 'data' => $collection), 200);
			}
		}
		
		
		/**
		 * @param       $data
		 * @param array $meta
		 * @return \Illuminate\Http\Response
		 */
		public function itemCreatedResponse($data, $meta = ['message' => 'Request successful.'])
		{
			if (empty($data)) {
				$data = (object)array();
			}
			
			return response()->json(array('meta' => $meta, 'data' => $data), 200);
		}
		
		/**
		 * @param       $data
		 * @param array $meta
		 * @return \Illuminate\Http\Response
		 */
		public function itemUpdatedResponse($data = array(), $meta = ['message' => 'Request successful.'])
		{
			
			if (empty($data)) {
				$data = (object)array();
			}
			
			return response()->json(array('meta' => $meta, 'data' => $data), 200);
		}
		
		/**
		 * @param       $data
		 * @param array $meta
		 * @return \Illuminate\Http\Response
		 */
		public function itemDeletedResponse($data, $meta = ['message' => 'Request successful.'])
		{
			if (empty($data)) {
				$data = (object)array();
			}
			
			return response()->json(array('meta' => $meta, 'data' => $data), 200);
		}
		
		/**
		 * @param array                                    $data
		 * @param \League\Fractal\TransformerAbstract|null $transformer
		 * @param array                                    $meta
		 * @return \Illuminate\Http\Response
		 */
		public function arrayResponse(array $data, TransformerAbstract $transformer = null, array $meta = ['message' => 'Request successful.'])
		{
			
			if (!is_null($transformer)) {
				
				$data = Fractal::collection($data, $transformer)->toArray();
				
				return response()->json(array('meta' => $meta, 'data' => $data['data']), 200);
			} else {
				return response()->json(array('meta' => $meta, 'data' => $data), 200);
			}
		}
	}
