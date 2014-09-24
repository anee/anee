<?php


namespace App\Searching;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class Utils {


	/**
	 * @param $filterArray
	 * @return array
	 */
    public static function checkValuesArray($filterArray)
    {
        $values = Utils::clearValuesArray();

        if($filterArray == NULL) {
            return $values;
        } else {
            return array_merge($values, $filterArray);
        }
    }

	/**
	 * @return array
	 */
	public static function clearResultsArray()
	{
		return array(
			'entityObject' => NULL,
			'entityUrl' => '',
			'count' => 0,
			'events' => array(),
			'tracks' => array(),
			'places' => array(),
			'photos' => array(),
			'eventsCount' => 0,
			'tracksCount' => 0,
			'placesCount' => 0,
			'photosCount' => 0
		);
	}

	/**
	 * @return array
	 */
	public static function clearValuesArray()
	{
		return array(
			'search' => '',
			'filterCategory' => array(),
			'filterTransport' => array(),
			'filterTime' => '',
			'filterSortBy' => '',
			'filterEntity' => '',
			'filterEntityId' => ''
		);
	}
} 