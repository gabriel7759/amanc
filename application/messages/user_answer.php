<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'answer' => array(
		'not_empty' => utf8_encode('Du har ikke svart på oppgaven.'),
		//'Model_User_Answer::unique_answer' => utf8_encode('Du har brukt opp sjansene dine på denne luken.'),
		'Model_User_Answer::unique_answer' => utf8_encode('Du har allerede svart riktig på dagens luke.'),
		'Model_User_Answer::check_day' => utf8_encode('Denne luken er lukket.'),
	),
);