<?php


namespace App;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class FilterUtils {


    public static function timeSubFilterTime($filterTime)
    {
        $time = new \DateTime;
        if($filterTime == 'Past hour') {
            return $time->sub(new \DateInterval('PT1H'));
        } else if ($filterTime == 'Past week') {
            return $time->sub(new \DateInterval('P7D'));
        } else if ($filterTime == 'Past month') {
            return $time->sub(new \DateInterval('P30D'));
        } else if ($filterTime == 'Past year') {
            return $time->sub(new \DateInterval('P365D'));
        } else {
            return $time;
        }
    }

    public static function checkArray($filterArray)
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

    public static function arrayContainsOrEmpty($value, $array)
    {
        if(empty($array) == true) {
            return true;
        } else {
            foreach($array as $i => $v) {
                if($v == $value) {
                    return true;
                }
            }
            return false;
        }
    }

    public static function arrayContains($value, $array)
    {
        foreach($array as $i => $v) {
            if($v == $value) {
                return true;
            }
        }
        return false;
    }

	public static function arrayContainsOnly($value, $array)
	{
		if(count($array) != 1) {
			return false;
		}
		foreach($array as $i => $v) {
			if($v == $value) {
				return true;
			}
		}
		return false;
	}
} 