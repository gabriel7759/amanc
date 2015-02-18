<?php defined('SYSPATH') or die('No direct script access.');

class JSON {
	
	const NUMERIC_CHECK = 1;
	
	public static function encode($input, $option = 0)
	{
		$json = json_encode($input);
		
		if ($option == self::NUMERIC_CHECK)
			return preg_replace( "/\"(\d+)\"/", '$1', $json);
		
		return $json;
	}

}