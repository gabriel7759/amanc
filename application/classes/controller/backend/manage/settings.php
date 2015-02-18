<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Manage_Settings extends Controller_Backend_Template {
	
	public function before()
	{
		parent::before();
		
		$this->model  = new Model_Sys_Setting;
	}
		
	public function action_index()
	{
		$data = $this->model->fetch_all();
		
		if ($_POST)
		{
			$this->model->update($_POST);
			Request::current()->redirect($this->_index_action.'?done');
		}
		
		$this->template->content->data  = $data;
	}

}