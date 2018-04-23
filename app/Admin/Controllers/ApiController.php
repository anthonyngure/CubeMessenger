<?php
	/**
	 * Created by PhpStorm.
	 * User: Tosh
	 * Date: 23/04/2018
	 * Time: 10:18
	 */
	
	namespace App\Admin\Controllers;
	
	
	use App\Client;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	
	class ApiController extends Controller
	{
		
		public function clients(Request $request)
		{
			$q = $request->get('q');
			
			return Client::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
		}
		
	}