<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Chapter extends Controller {

	public function action_index()
	{
		$number = $this->request->param('number');
		
		$chapter = Model::factory('Chapter')->fetch(array(
			'number' => $number,
		));
		
		$view = View::factory('facebook');
		$view->site_name   = utf8_encode('Dusørjakten');
		$view->title       = $chapter['fb_title'];
		$view->thumbnail   = $chapter['fb_thumb'];
		$view->description = $chapter['description'];
		$view->number      = $number;
		
		if (empty($chapter['date_released']))
			throw new HTTP_Exception_404('Episode :number does not exist', array(':number' => $number));
		
		if (strpos(Request::$user_agent, 'facebookexternalhit') === FALSE)
			Request::current()->redirect('/');
			
		$this->response->body($view);
	}

}