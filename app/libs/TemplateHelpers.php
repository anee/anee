<?php

namespace App;

use Nette;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TemplateHelpers {

    /**
     * @throws \Nette\StaticClassException
     */
    final public function __construct()
    {
        throw new Nette\StaticClassException;
    }

    /**
     * Try to load the requested helper.
     *
     * @param  string  helper name
     *
     * @return callback
     */
	public static function loader($helper) {
		if (method_exists(__CLASS__, $helper))
			return call_user_func_array('App\TemplateHelpers::'.$helper, array_slice(func_get_args(), 1));
	}

    public static function strtolower($text)
    {
        return strtolower($text);
    }

    public static function getSpanTimeFromSecondsNumberNoSpan($seconds)
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
    }

    public static function getSpanTimeFromSecondsNumber($secParam)
    {
        $hours = floor($secParam / 3600);
        $minutes = floor(($secParam / 60) % 60);
        $seconds = $secParam % 60;

        return "$hours:$minutes:$seconds";
    }
	public static function fromSecondsHours($secParam)
	{
		$hours = floor($secParam / 3600);
		return $hours;
	}
	public static function fromSecondsMinutes($secParam)
	{
		$minutes = floor(($secParam / 60) % 60);
		return $minutes;
	}
	public static function fromSecondsSeconds($secParam)
	{
		$seconds = $secParam % 60;
		return $seconds;
	}
    public static function getSpanTimeFromSecondsText($seconds)
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
    }

    public static function getSpanTimeFromSecondsTextValue($seconds)
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
    }

	/**
	 * For example "8"
	 * @param $date
	 * @return string
	 */
    public static function dateAgoNumber($date)
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
    }

	/**
	 * For example "days ago"
	 * @param $date
	 * @return string
	 */
    public static function dateAgoText($date)
    {
        $value = null;
        $seconds = round((date('U') - $date->format('U')));

        if ($seconds < 60)
            $value = " sec";
        else if($seconds < 60*60)
            $value = " min";
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
    }

    public static function isSelected($value, $array) {
        foreach($array as $i => $v) {
            if($v == $value) {
                return true;
            }
        }
        return false;
    }

    public static function selectedOrNothing($value, $array)
    {
        foreach($array as $i => $v) {
            if($v == $value) {
                return 'selected';
            }
        }
        return '';
    }

    public static function arrayContainsOneOrMore($valueArray, $array)
    {
        if(empty($array) == true) {
            return false;
        } else {
            foreach($array as $i => $v)
                foreach($valueArray as $value) {
                    if($v == $value) {
                        return true;
                    }
                }
            return false;
        }
    }

	/**
	 * Same function as strpos in classic php
	 * @param $name
	 * @param $searchingValue
	 * @return bool
	 */
	public static function strpos($name, $searchingValue)
	{
		if (strpos($name, $searchingValue) !== false) {
			return true;
		} else {
			return false;
		}
	}
}
