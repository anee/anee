<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 13.8.14
 * Time: 15:45
 */

namespace App\Utils;


class timeUtils {

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
} 