<?php


namespace App\Utils;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class Strings {

	/**
	 * Take part of string after substring
	 * @param $string
	 * @param $substring
	 * @return string
	 */
	public static function strafter($string, $substring) {
		$pos = strpos($string, $substring);
		if ($pos === false)
			return $string;
		else
			return(substr($string, $pos+strlen($substring)));
	}

	/**
	 * Take part of string before substring
	 * @param $string
	 * @param $substring
	 * @return string
	 */
	public static function strbefore($string, $substring)
	{
		$pos = strpos($string, $substring);
		if ($pos === false)
			return $string;
		else
			return (substr($string, 0, $pos));
	}
} 