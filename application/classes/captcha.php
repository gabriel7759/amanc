<?php defined('SYSPATH') or die('No direct script access.');

class Captcha {
	
	public static function render($response)
	{
		$words1 = array(
			utf8_encode('skip '),
			utf8_encode('gull '),
			utf8_encode('tiara'),
			utf8_encode('julie'),
			utf8_encode('flaks'),
			utf8_encode('pirat'),
		);
		$words2 = array(
			//utf8_encode('        dusør'),
			utf8_encode('       septer'),
			//utf8_encode('   sjørøver'),
			utf8_encode('skattekiste'),
			utf8_encode('     dublon'),
			//utf8_encode('  papegøye'),
			utf8_encode('    parasoll'),
			//utf8_encode(' lillestrøm'),
			utf8_encode('     sparing'),
			utf8_encode('  superspar'),
			utf8_encode('   godrente'),
			utf8_encode('      gallion'),
			utf8_encode('    trebein'),
			utf8_encode('   bramseil'),
			utf8_encode('  romflaske'),
			utf8_encode(' skattejakt'),
			utf8_encode('  gullkjede'),
			utf8_encode('kongekrone'),
			utf8_encode('spareavtale'),
			utf8_encode('   nedgravd'),
			//utf8_encode('      sjøslag'),
			utf8_encode('      george'),
		);
		
		$response->headers('Content-Type', 'image/png');
		
		$word1 = $words1[array_rand($words1)];
		$word2 = $words2[array_rand($words2)];
		
		Session::instance()->set('captcha', UTF8::trim($word1).' '.UTF8::trim($word2));
		
		$bg     = rand(1,6);
		$angle1 = rand(-4,4);
		$angle2 = rand(-4,3);
		
		$im    = imagecreatefrompng("assets/images/backend/captcha/bg$bg.png");
		$white = imagecolorallocate($im, 255, 255, 255);
		$font  = 'assets/fonts/pt_sans-webfont.ttf';
		
		imagettftext($im, 18, $angle1, 10, 22, $white, $font, $word1);
		imagettftext($im, 18, $angle2, 66, 20, $white, $font, $word2);
		imagepng($im);
		imagedestroy($im);
	}
	
	public static function valid($input)
	{
		return (Session::instance()->get('captcha') == UTF8::trim($input));
	}

}