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
	public static function clearValuesArray()
	{
		return array(
			'search' => '',
			'userId' => '',
			'filterCategory' => array(),
			'filterTransport' => array(),
			'filterTimeStart' => '',
			'filterTimeEnd' => '',
			'filterSortBy' => '',
			'filterEntity' => '',
			'filterEntityId' => ''
		);
	}
} 