<?php
	/**
	 * Created by PhpStorm.
	 * User: Tosh
	 * Date: 05/12/2017
	 * Time: 20:41
	 */
	
	namespace App;
	
	
	class LocationUtil
	{
		
		
		public static function nearMost($latitude, $longitude, string $table, $columns = '',
		                                $where = null, $limit = 15, $radius = 50.0)
		{
			
			$whereRadiusLatitudeLessThan50 = "latitude BETWEEN inputLatitude - ("
				. $radius . " / 111.045) AND inputLatitude + (" . $radius . " / 111.045)";
			
			$whereRadiusLongitudeLessThan50 = "longitude BETWEEN inputLongitude - (" . $radius . " / (111.045 * COS(RADIANS(inputLatitude))))" .
				" AND inputLongitude + (" . $radius . " / (111.045 * COS(RADIANS(inputLatitude))))";
			
			
			$joinStatement = "(SELECT  " . $latitude . "  AS inputLatitude,  " . $longitude . " AS inputLongitude, " . $radius .
				" AS radius, 111.045 AS distance_unit)";
			
			$distanceSelection = "111.045 * DEGREES(ACOS(COS(RADIANS(inputLatitude)) * COS(RADIANS(latitude))" .
				" * COS(RADIANS(inputLongitude) - RADIANS(longitude)) + SIN(RADIANS(inputLatitude)) * SIN(RADIANS(latitude))))" .
				" AS distance";
			$selection = "latitude, longitude";
			
			if (empty($columns)) {
				$fullSelection = $selection . "," . $distanceSelection;
			} else {
				$fullSelection = $selection . "," . $distanceSelection . "," . $columns;
			}
			
			
			if (empty($where)) {
				$finalQuery = "SELECT " . $fullSelection . " FROM " . $table . " JOIN " . $joinStatement .
					" AS p ON 1=1 WHERE " . $whereRadiusLatitudeLessThan50 . " AND " . $whereRadiusLongitudeLessThan50 .
					" ORDER BY distance DESC LIMIT " . $limit;
			} else {
				$finalQuery = "SELECT " . $fullSelection . " FROM " . $table . " JOIN " . $joinStatement .
					" AS p ON 1=1 WHERE " . $whereRadiusLatitudeLessThan50 . " AND " . $whereRadiusLongitudeLessThan50 .
					" AND " . $where . " ORDER BY distance LIMIT " . $limit;
			}
			
			return $finalQuery;
		}
	}