<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Template extends Controller_Template {
	
	public $template;
	public $integra_session;
	
	protected $_directory;
	protected $_controller;
	protected $_action;
	
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		
		$this->_directory  = Request::$current->directory();
		$this->_controller = Request::$current->controller();
		$this->_action     = Request::$current->action();
		$this->integra_session = Session::instance();

		$this->voluntario = Model::factory('Voluntario');
		$this->actividad = Model::factory('Activity');
		$this->estado = Model::factory('state');
		$this->tag = Model::factory('tag');
	}
	
	public function before()
	{
		$user_front = Session::instance()->get('identity_front');
		
		if (!isset($user_front) && $this->request->controller() == 'privado' && $this->request->action() != 'login' && $this->request->action() != 'logout')
		{
			Request::current()->redirect('/');
		}
		
		if(!$user_front)
		{
			$user_front = 0;
		}

		// Render JSON for Ajax requests
		if (Request::current()->is_ajax())
		{
			$this->auto_render = FALSE;
			
			$this->response->headers('Content-Type', 'application/json');
			$this->response->headers('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
		}
		
		$this->template = 'frontend/template';
		
		parent::before();

		// Template variables
		if ($this->auto_render === TRUE)
		{
//			$this->template->facebook   = Kohana::$config->load('facebook.appid');
			$this->template->facebook  = Model_Sys_Setting::value('facebook_url');
			$this->template->twitter  = Model_Sys_Setting::value('twitter_url');
			$this->template->analytics  = Model_Sys_Setting::value('google_analytics');
			$this->template->siteurl    = "http://".$_SERVER['SERVER_NAME']."/";
			$this->template->menu       = Model::factory('Content')->fetch_childrens(array('id_parent' => '2'))->as_array();
			$this->template->sitemap    = Model::factory('Content')->fetch_menu();
			$this->template->mobile     = $this->_mobile();
			$this->template->action     = $this->_action;
			$this->template->slides     = array();
			$this->template->is_home    = false;
			$this->template->title      = "";
			$this->template->user_front = $user_front;
			
			$this->template->section = $this->request->param('section');
			$this->template->page    = $this->request->param('page');
		}
	}
	
	
	protected function _mobile()
	{
		return (strpos(strtolower(Request::$user_agent), 'mobile') !== FALSE) ? 'mobile': '';
	}

}