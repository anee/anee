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
    public static function returnTimeStart($filterTime)
    {
        if($filterTime == 'Today') {
            return new \DateTime("midnight today");
        } elseif($filterTime == 'Yesterday') {
            return new \DateTime("midnight yesterday");
        } elseif($filterTime == 'Past hour') {
            return $time->sub(new \DateInterval('PT1H'));
        } else if ($filterTime == 'Past week') {
            return $time->sub(new \DateInterval('P7D'));
        } else if ($filterTime == 'Past month') {
            return $time->sub(new \DateInterval('P30D'));
        } else if ($filterTime == 'Past year') {
            return $time->sub(new \DateInterval('P365D'));
        } else if (explode(" ", $filterTime)[1] > 0) {
          $date = new \DateTime;
          $date->setDate(explode(" ", $filterTime)[1] - 1,12,31);
          $date->setTime(23, 59, 59);
          return $date;
        }
    }

    /**
  	 * @param $filterTime
  	 * @return \DateTime
  	 */
    public static function returnTimeEnd($filterTime)
    {
      if (explode(" ", $filterTime)[1] > 0) {
        $date = new \DateTime;
        $date->setDate(explode(" ", $filterTime)[1],12,31);
        $date->setTime(23, 59, 59);
        return $date;
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
