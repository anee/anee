<?php


namespace App\Utils;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class Arrays {


	/**
	 * @param $filterTime
	 * @return \DateTime
	 */
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

	/**
	 * @param $value
	 * @param $arr
	 * @return bool
	 */
    public static function arrayContainsOrEmpty($value, $arr)
    {
        if(empty($arr) == true) {
            return true;
        } else {
            foreach($arr as $i => $v) {
                if($v == $value) {
                    return true;
                }
            }
            return false;
        }
    }

	/**
	 * @param $value
	 * @param $arr
	 * @return bool
	 */
    public static function arrayContains($value, $arr)
    {
        foreach($arr as $i => $v) {
            if($v == $value) {
                return true;
            }
        }
        return false;
    }

	/**
	 * @param $value
	 * @param $arr
	 * @return bool
	 */
	public static function arrayContainsOnly($value, $arr)
	{
		if(count($arr) != 1) {
			return false;
		}
		foreach($arr as $i => $v) {
			if($v == $value) {
				return true;
			}
		}
		return false;
	}
} 