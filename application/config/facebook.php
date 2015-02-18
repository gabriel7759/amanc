<?php defined('SYSPATH') or die('No direct access allowed.');

if (Kohana::$environment == Kohana::PRODUCTION)
{
	return array
	(
		'appid'  => '',
		'secret' => '',
	);
} 
elseif (Kohana::$environment == Kohana::STAGING)
{
	return array
	(
		'appid'  => '',
		'secret' => '',
	);
}
elseif (Kohana::$environment == Kohana::DEVELOPMENT)
{
	return array
	(
		'appid'  => '',
		'secret' => '',
	);
}