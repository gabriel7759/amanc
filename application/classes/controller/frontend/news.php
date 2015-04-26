<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_News extends Controller_Frontend_Template {

	function before() {
		parent::before();
	}
		
	 public function action_details() {
	 	$id_news = $this->request->param('id_news');
	 	
	 	$data = Model::factory('News')->fetch(array('id'=>$id_news));
	 	$this->template->content = View::factory('frontend/news/detail')->set('data', $data);
	 }
	 
}