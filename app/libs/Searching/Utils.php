<?php


namespace App\Searching;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class Utils {


    public static function checkValuesArray($filterArray)
    {
        $values = array(
            'search' => '',
            'filterCategory' => array(),
            'filterTransport' => array(),
            'filterTime' => '',
            'filterEntity' => '',
            'filterEntityId' => ''
        );

        if($filterArray == NULL) {
            return $values;
        } else {
            return array_merge($values, $filterArray);
        }
    }

	public static function clearResultsArray()
	{
		return array(
			'EntityObject' => NULL,
			'EntityUrl' => '',
			'Count' => 0,
			'Events' => array(),
			'Tracks' => array(),
			'Places' => array(),
			'Photos' => array(),
			'EventsCount' => 0,
			'TracksCount' => 0,
			'PlacesCount' => 0,
			'PhotosCount' => 0
		);
	}

	public static function clearValuesArray()
	{
		return array(
			'search' => '',
			'filterCategory' => array(),
			'filterTransport' => array(),
			'filterTime' => '',
			'filterEntity' => '',
			'filterEntityId' => ''
		);
	}
} 