<?php
	
	namespace App\Transformers;
	
	use League\Fractal\TransformerAbstract;
	
	class DriverOptionTransformer extends TransformerAbstract
	{
		/**
		 * A Fractal transformer.
		 *
		 * @return array
		 */
		public function transform($datum)
		{
			return [
				'type'             => (string)$datum->type,
				'maximumWeight'    => number_format($datum->maximum_weight, 2),
				'maximumVolume'    => number_format($datum->maximum_volume, 2),
				'cost'             => number_format($datum->cost, 2),
				'distanceAway' => number_format($datum->distance, 4),
			];
		}
	}
