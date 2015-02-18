<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Voluntario extends Controller_Frontend_Template {
	function before(){
		parent::before();
	}
	public function action_voluntario_registro(){
		print 'hola';
		$data = array();
		$this->template->content = View::factory('frontend/voluntario/voluntario_registro')->set('data', $data);
	}
}