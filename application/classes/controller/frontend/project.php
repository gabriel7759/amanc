<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Project extends Controller_Frontend_Template {

	function before() {
		parent::before();
	}
		
	 public function action_details() {
	 	$id_project = $this->request->param('id_project');
	 	
	 	$data = Model::factory('Project')->fetch(array('id'=>$id_project));
	 	$this->template->content = View::factory('frontend/news/detail')->set('data', $data);
	 }
	 
}