<?php
	
	namespace App\Http\Controllers;
	
	use App\Client;
	use App\Exceptions\WrappedException;
	use Auth;
	use Fractal;
	use Illuminate\Database\Eloquent\Collection;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
	use Illuminate\Foundation\Bus\DispatchesJobs;
	use Illuminate\Foundation\Validation\ValidatesRequests;
	use Illuminate\Routing\Controller as BaseController;
	use League\Fractal\TransformerAbstract;
	
	class Controller extends BaseController
	{
		use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
		
		/**
		 * @throws \App\Exceptions\WrappedException
		 * @return \App\Client
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
