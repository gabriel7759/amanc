<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Start_Overview extends Controller_Backend_Template {

	public function action_index()
	{
		$view = View::factory('backend/start/overview/index')
			->set('sitename', $this->template->sitename);
		
		$this->template->title = 'Start';
		$this->template->content = $view;
	}

}