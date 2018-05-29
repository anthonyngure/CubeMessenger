<?php
	
	namespace App\Http\Controllers;
	
	use App\CrudHeader;
	use App\TopUp;
	use Illuminate\Http\Request;
	
	class TopUpController extends Controller
	{
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$headers = CrudHeader::whereModel(TopUp::class)->get();
			
			$topUps = TopUp::with('client')->get();
			
			return $this->collectionResponse($topUps, ['headers' => $headers]);
		}
		
		
		/**
		 * Store a newly created resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\Response
		 */
		public function store(Request $request)
		{
			$this->validate($request, [
				'amount'   => 'required|numeric',
				'clientId' => 'required|exists:clients,id',
			]);
			
			$topUp = TopUp::create([
				'amount'    => $request->input('amount'),
				'client_id' => $request->input('clientId'),
			]);
			
			
			return $this->show($topUp->id);
			
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function show($id)
		{
			$topUp = TopUp::with('client')->findOrFail($id);
			
			return $this->itemResponse($topUp);
		}
		
		/**
		 * Show the form for editing the specified resource.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function edit($id)
		{
			//
		}
		
		/**
		 * Update the specified resource in storage.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  int                      $id
		 * @return \Illuminate\Http\Response
		 */
		public function update(Request $request, $id)
		{
			//
		}
		
		/**
		 * Remove the specified resource from storage.
		 *
		 * @param  int $id
		 * @return \Illuminate\Http\Response
		 */
		public function destroy($id)
		{
			//
		}
	}
