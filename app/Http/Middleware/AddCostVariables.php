<?php
	
	namespace App\Http\Middleware;
	
	use App\CostVariable;
	use Closure;
	
	class AddCostVariables
	{
		/**
		 * Handle an incoming request.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \Closure                 $next
		 * @return mixed
		 */
		public function handle($request, Closure $next)
		{
			/** @var \Illuminate\Http\Response $response */
			$response = $next($request);
			
			if ($request->withVariables) {
				// Perform action
				$data = $response->getOriginalContent();
				
				$variables = CostVariable::wherePublic(true)->get(['name', 'value']);
				
				$nameValuesArray = array();
				
				foreach ($variables as $variable) {
					array_push($nameValuesArray, [$variable->name => $variable->value,]);
				}
				
				$nameValuesCollection = collect($nameValuesArray);
				
				$nameValuesCollapsed = $nameValuesCollection->collapse();
				
				$newData = array_merge(['variables' => $nameValuesCollapsed->all()], $data);
				
				$response->setContent(json_encode($newData));
			}
			
			return $response;
		}
	}
