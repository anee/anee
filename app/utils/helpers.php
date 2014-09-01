<?php
/**
 * Created by PhpStorm.
 * User: Phantom
 * Date: 13.8.14
 * Time: 18:24
 */

namespace App\Utils;


class helpers {


    public static function loader($template)
    {
        $template->addFilter('strtolower', function($text)
        {
            return strtolower($text);
        });
        $template->addFilter('getSpanTimeFromSecondsNumber', function($seconds)
        {
            $value = null;

            if ($seconds < 60)
                $value = round($seconds, 2);
            else if($seconds < 60*60)
                $value = round($seconds/60, 2);
            else if($seconds < 60*60*24)
                $value = round($seconds/(60 * 60), 2);
            else if($seconds < 60*60*24*30)
                $value = round($seconds/(60 * 60 * 24), 2);
            else
                $value = round($seconds/(60 * 60 * 24 * 30), 2);

            return $value;
        });
        $template->addFilter('getSpanTimeFromSecondsText', function($seconds)
        {
            $value = null;

            if ($seconds < 60)
                $value = " SECOND";
            else if($seconds < 60*60)
                $value = " MINUTE";
            else if($seconds < 60*60*24)
                $value = " HOUR";
            else if($seconds < 60*60*24*30)
                $value = " DAY";
            else
                $value = " MONTH";

            // if is value another from "1" add "s"
            if ($value != 1)
                $value = $value."S";

            return $value;
        });
        $template->addFilter('getSpanTimeFromSecondsTextValue', function($seconds)
        {
            $value = null;

            if ($seconds < 60)
                $value = " SECOND";
            else if($seconds < 60*60)
                $value = " MINUTE";
            else if($seconds < 60*60*24)
                $value = " HOUR";
            else if($seconds < 60*60*24*30)
                $value = " DAY";
            else
                $value = " MONTH";

            return $value;
        });
        $template->addFilter('getDateAgoNumber', function($date)
        {
            $value = null;
            $seconds = round((date('U') - $date->format('U')));

            if ($seconds < 60)
                $value = round((date('U') - $date->format('U')));
            else if($seconds < 60*60)
                $value = round((date('U') - $date->format('U'))/(60));
            else if($seconds < 60*60*24)
                $value = round((date('U') - $date->format('U'))/(60 * 60));
            else if($seconds < 60*60*24*30)
                $value = round((date('U') - $date->format('U'))/(60 * 60 * 24));
            else
                $value = round((date('U') - $date->format('U'))/(60 * 60 * 24 * 30));

            return $value;
        });
        $template->addFilter('getDateAgoText', function($date)
        {
            $value = null;
            $seconds = round((date('U') - $date->format('U')));

            if ($seconds < 60)
                $value = " second";
            else if($seconds < 60*60)
                $value = " minute";
            else if($seconds < 60*60*24)
                $value = " hour";
            else if($seconds < 60*60*24*30)
                $value = " day";
            else
                $value = " month";

            // if is value another from "1" add "s"
            if ($value != 1)
                $value = $value."s";

            // end of date
            $value = $value." ago";

            return $value;
        });
        $template->addFilter('selectedOrNothing', function($value, $array)
        {
            foreach($array as $i => $v) {
                if($v == $value) {
                    return 'selected';
                }
            }
            return '';
        });
    }
} 