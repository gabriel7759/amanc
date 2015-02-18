<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'name' => array(
		'not_empty' => __('Please enter the name.'),
	),
	'email' => array(
		'not_empty' => __('Please enter the email.'),
		'email' => __('Please enter a valid email address.'),
		'Model_Sys_User::unique_email' => __('The email address is already registered'),
	),
	'password' => array(
		'not_empty' => __('Please enter the password'),
		'min_length' => __('Password must contain at least 8 characters.'),
	),
	'confirm' => array(
		'not_empty' => utf8_encode('Feltet "bekreft passord" kan ikke være tomt.'),
		'matches' => utf8_encode('Feltene "passord" og "bekreft passord" må være like.'),
	),
);