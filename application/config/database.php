<?php defined('SYSPATH') or die('No direct access allowed.');

if (Kohana::$environment == Kohana::PRODUCTION)
{
	return array
	(
		'default' => array
		(
			'type'       => 'mysql',
			'connection' => array(
				'hostname'   => 'localhost',
				'database'   => 'amancorg_amanc',
				'username'   => 'amanc_user',
				'password'   => 'flako1979',
				'persistent' => FALSE,
			),		
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
			'profiling'    => FALSE,
		),
	);
} 
elseif (Kohana::$environment == Kohana::STAGING)
{
	return array
	(
		'default' => array
		(
			'type'       => 'mysql',
			'connection' => array(
				'hostname'   => 'db550574431.db.1and1.com',
				'database'   => 'db550574431',
				'username'   => 'dbo550574431',
				'password'   => 'flako1979',
				'persistent' => FALSE,
			),
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
			'profiling'    => TRUE,
		),
	);
}
elseif (Kohana::$environment == Kohana::DEVELOPMENT)
{
	return array
	(
		'default' => array
		(
			'type'       => 'mysql',
			'connection' => array(
				'hostname'   => 'localhost',
				'database'   => 'amanc',
				'username'   => 'root',
				'password'   => 'root',
				'persistent' => FALSE,
			),
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
			'profiling'    => TRUE,
		),
	);
}
