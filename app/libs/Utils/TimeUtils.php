<?php


namespace App\Utils;



/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */
class TimeUtils {

	public static function fromSecondsHours($secParam) {
		$hours = floor($secParam / 3600);
		return $hours;
	}
	public static function fromSecondsMinutes($secParam) {
		$minutes = floor(($secParam / 60) % 60);
		return $minutes;
	}
	public static function fromSecondsSeconds($secParam) {
		$seconds = $secParam % 60;
		return $seconds;
	}

	public static function fromSpanToSeconds($hours, $minutes, $seconds) {
		$secondsTotal = 0;
		if(is_numeric($hours)) {
			$secondsTotal += $hours * 3600;
		}
		if(is_numeric($minutes)) {
			$secondsTotal += $minutes * 60;
		}
		if(is_numeric($seconds)) {
			$secondsTotal += $seconds;
		}
		return $secondsTotal;
	}
} 