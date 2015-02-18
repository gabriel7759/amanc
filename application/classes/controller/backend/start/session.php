<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Start_Session extends Controller_Backend_Template {
	
	public function action_login()
	{
		$username = Arr::get($_POST, 'username');
		$password = Arr::get($_POST, 'password');
		$remember = array_key_exists('remember', $_POST);
		
		$this->template->content->error = FALSE;
		
		if ($_POST)
		{
			if (Auth::instance()->login($username, $password, $remember))
			{
				Security::token(TRUE);
				Request::current()->redirect('/admin/start/overview/index');
			}
			$this->template->content->error = TRUE;
		}
		
		$this->template->title = 'Login';
		$this->template->content->username = $username;
	}
	
	public function action_logout()
	{
		Auth::instance()->logout();
		Request::current()->redirect('/admin/start/session/login');
	}
	
	public function action_password()
	{
		$username = Arr::get($_POST, 'username');
		
		$this->template->content->error = FALSE;
		
		if($_POST)
		{
			$_POST['success'] = Model::factory('Sys_User')->forgot($_POST['email']);
			
			if ($_POST['success'])
			{
				$_POST['sent'] = TRUE; 
			}
		}
		
		$this->template->title = 'Password recovery';
		$this->template->content->username = $username;
	}
	
	public function action_reset()
	{
		
	}

}