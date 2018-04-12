<?php
	
	namespace App\Http\Middleware;
	
	use App\CostVariable;
	use Carbon\Carbon;
	use Closure;
	
	class AddVariables
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
			
			// Perform action
			$data = $response->getOriginalContent();
			
			if ($request->withCostVariables) {
				
				
				$variables = CostVariable::wherePublic(true)->get(['name', 'value']);
				
				$nameValuesArray = array();
				
				foreach ($variables as $variable) {
					array_push($nameValuesArray, [$variable->name => $variable->value,]);
				}
				
				$nameValuesCollection = collect($nameValuesArray);
				
				$nameValuesCollapsed = $nameValuesCollection->collapse();
				
				$newData = array_merge(['costVariables' => $nameValuesCollapsed->all()], $data);
				$response->setContent(json_encode($newData));
				
				
			} else if ($request->withSystemVariables) {
				$variables = [
					'date'     => Carbon::now()->toDateString(),
					'time'     => Carbon::now()->toTimeString(),
					'dateTime' => Carbon::now()->toDateTimeString(),
				];
				$newData = array_merge(['systemVariables' => $variables], $data);
				$response->setContent(json_encode($newData));
			}
			
			return $response;
		}
	}
