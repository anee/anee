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
			'username' => '',
			'usernameUrl' => '',
			'filterCategory' => array(),
			'filterTransport' => array(),
			'filterTimeStart' => '',
			'filterTimeEnd' => '',
			'filterSortBy' => '',
			'filterEntity' => '',
			'filterEntityId' => ''
		);
	}

    /**
     * @return array
     */
    public static function getFromStartStrings() {
        return array(
            'Past hour' => 'Past hour',
            'Today' => 'Today',
            'Yesterday' => 'Yesterday',
            'Past week' => 'Past week',
            'Past month' => 'Past month',
            'Past year' => 'Past year',
        );
    }

    /**
     * @return array
     */
    public static function getCategories()
    {
        return array(
            'Tracks' => 'Tracks',
            'Places' => 'Places',
            'Photos' => 'Photos',
        );
    }
} 