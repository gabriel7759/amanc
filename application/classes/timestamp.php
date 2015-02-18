<?php defined('SYSPATH') or die('No direct script access.');

class Timestamp extends Kohana_Date {
	
	public static function format($time = NULL, $format = '%Y-%m-%d %H:%M:%S')
	{
		if ( ! $time)
			return NULL;
		
		if ( ! (string) ctype_digit($time))
			return $time;
		
		return strftime($format, $time);
	}
	
}