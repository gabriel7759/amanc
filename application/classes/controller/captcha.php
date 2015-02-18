<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Captcha extends Controller {
	
	public function action_index()
	{
		Captcha::render($this->response);
	}

}