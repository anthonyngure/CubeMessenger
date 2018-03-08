<?php
	
	namespace App;
	
	class Geo
	{
		const EARTH_RADIUS = 6371; // in km
		
		/**
		 * Given a $centre (latitude, longitude) co-ordinates and a
		 * distance $radius (miles), returns a random point (latitude,longtitude)
		 * which is within $radius meters of $centre.
		 *
		 * @param $latitude
		 * @param $longitude
		 * @param float $radius The radius (in km).
		 *
		 * @return array
		 */
		public static function generateRandomPoint($latitude, $longitude, $radius)
		{
			$centre = array($latitude, $longitude);
			$radius_earth = self::EARTH_RADIUS; // in km
			
			// Pick random distance within $distance;
			$distance = lcg_value() * $radius;
			
			// Convert degrees to radians.
			$centre_rads = array_map('deg2rad', $centre);
			
			// First suppose our point is the north pole.
			// Find a random point $distance miles away
			$lat_rads = (pi() / 2) - $distance / $radius_earth;
			$lng_rads = lcg_value() * 2 * pi();
			
			// ($lat_rads,$lng_rads) is a point on the circle which is
			// $distance miles from the north pole. Convert to Cartesian
			$x1 = cos($lat_rads) * sin($lng_rads);
			$y1 = cos($lat_rads) * cos($lng_rads);
			$z1 = sin($lat_rads);
			
			// Rotate that sphere so that the north pole is now at $centre.
			
			// Rotate in x axis by $rot = (pi()/2) - $centre_rads[0];
			$rot = (pi() / 2) - $centre_rads[0];
			$x2 = $x1;
			$y2 = $y1 * cos($rot) + $z1 * sin($rot);
			$z2 = -$y1 * sin($rot) + $z1 * cos($rot);
			
			//Rotate in z axis by $rot = $centre_rads[1]
			$rot = $centre_rads[1];
			$x3 = $x2 * cos($rot) + $y2 * sin($rot);
			$y3 = -$x2 * sin($rot) + $y2 * cos($rot);
			$z3 = $z2;
			
			//Finally convert this point to polar co-ords
			$lng_rads = atan2($x3, $y3);
			$lat_rads = asin($z3);
			
			$return = array_map('rad2deg', array($lat_rads, $lng_rads));
			return array('latitude' => $return[0], 'longitude' => $return[1]);
		}
		
		/**
		 * Return the boundaries of a square around a geo point according the specified distance
		 *
		 * @param $latitude
		 * @param $longitude
		 * @param int $distance
		 * @return array
		 */
		public static function getGeoBoundaries($latitude, $longitude, $distance=2000)
		{
			// earth's radius in km = ~6371
			$radius = self::EARTH_RADIUS * 1609.344;
			$return = array(
				'ref_lat' => $latitude,
				'ref_lng' => $longitude,
				'distance' => $distance,
				'max_lat' => null,
				'min_lat' => null,
				'max_lng' => null,
				'min_lng' => null,
			);
			
			// latitude boundaries
			$return['max_lat'] = $latitude + rad2deg($distance / $radius);
			$return['min_lat'] = $latitude - rad2deg($distance / $radius);
			
			// longitude boundaries (longitude gets smaller when latitude increases)
			$return['max_lng'] = $longitude + rad2deg($distance / $radius / cos(deg2rad($latitude)));
			$return['min_lng'] = $longitude - rad2deg($distance / $radius / cos(deg2rad($latitude)));
			
			return $return;
		}
		
		/**
		 * Return the great-circle distance in meters between 2 geo points using the Vincenty formula (more precise)
		 *
		 * @param float $lat1
		 * @param float $lng1
		 * @param float $lat2
		 * @param float $lng2
		 *
		 * @return float distance in meters
		 */
		public static function distance($lat1, $lng1, $lat2, $lng2)
		{
			$earthRadius = self::EARTH_RADIUS * 1609.344;
			
			// convert from degrees to radians
			$latFrom = deg2rad($lat1);
			$lonFrom = deg2rad($lng1);
			$latTo = deg2rad($lat2);
			$lonTo = deg2rad($lng2);
			
			$lonDelta = $lonTo - $lonFrom;
			$a = pow(cos($latTo) * sin($lonDelta), 2) +
				pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
			$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
			
			$angle = atan2(sqrt($a), $b);
			return $angle * $earthRadius;
		}
	}