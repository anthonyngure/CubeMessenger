<?php
	
	namespace App\Http\Controllers;
	
	use App\ServiceRequest;
	use App\ServiceRequestItem;
	use App\ServiceRequestQuote;
	use Illuminate\Http\Request;
	
	class ServiceRequestQuoteController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			//
		}
		
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			//
			
			$this->validate($request, [
				'serviceRequestId' => 'required|exists:service_requests,id',
				'diagnosisCost'    => 'required|numeric',
				'labourCost'       => 'required|numeric',
				'items'            => 'required',
			]);
			
			$serviceRequest = ServiceRequest::findOrFail($request->json('serviceRequestId'));
			
			$serviceRequestQuote = ServiceRequestQuote::updateOrCreate([
				'service_request_id' => $serviceRequest->getKey(),
			], [
				'diagnosis_cost' => $request->json('diagnosisCost'),
				'labour_cost'    => $request->json('labourCost'),
				'note'           => $request->json('note'),
			]);
			
			$items = $request->json('items');
			
			foreach ($items as $item) {
				ServiceRequestItem::updateOrCreate([
					'service_request_quote_id' => $serviceRequestQuote->getKey(),
					'price'                    => $item['price'],
					'name'                     => $item['name'],
				], [
					'note' => $item['note'],
				]);
			}
			//dd($items);
			
			//Update Service Request status to PENDING_QUOTE_CONFIRMATION
			$serviceRequest->status = 'PENDING_QUOTE_CONFIRMATION';
			$serviceRequest->save();
			
			$data = ServiceRequestQuote::with('items')->findOrFail($serviceRequestQuote->getKey());
			
			return $this->itemResponse($data);
			
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  \App\ServiceRequestQuote $serviceRequestQuote
		 * @return \Illuminate\Http\Response
		 */
		public function show(ServiceRequestQuote $serviceRequestQuote)
		{
			//
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  \App\ServiceRequestQuote $serviceRequestQuote
		 * @return \Illuminate\Http\Response
		 */
		public function edit(ServiceRequestQuote $serviceRequestQuote)
		{
			//
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \App\ServiceRequestQuote $serviceRequestQuote
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, ServiceRequestQuote $serviceRequestQuote)
		{
			//
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  \App\ServiceRequestQuote $serviceRequestQuote
		 * @return \Illuminate\Http\Response
		 */
		public function destroy(ServiceRequestQuote $serviceRequestQuote)
		{
			//
		}
		
		public function acceptQuote(Request $request, $id)
		{
			$serviceRequest = ServiceRequest::findOrFail($id);
			$serviceRequest->status = 'PENDING_ATTENDANCE';
			$serviceRequest->save();
			
			return view('quote_accepted');
		}
		
		public function rejectQuote(Request $request, $id)
		{
			$serviceRequest = ServiceRequest::findOrFail($id);
			$serviceRequest->status = 'QUOTE_REJECTED';
			$serviceRequest->save();
			
			return view('quote_rejected');
		}
	}
