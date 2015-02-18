<?php defined('SYSPATH') or die('No direct script access.');

class Facebook_Autoloader {
	public static function autoload($class)
	{
		if ($class == 'Facebook')
		{
			include_once Kohana::find_file('vendor', 'facebook/facebook');
		}
	}
}

// Register the autoloader
spl_autoload_register(array('Facebook_Autoloader', 'autoload'));
