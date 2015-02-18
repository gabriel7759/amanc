<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Manage_Siteconfig extends Controller_Backend_Template {
	
	public function before()
	{
		parent::before();
		
		$this->model  = new Model_Siteconfig;
	}
	
	public function action_index()
	{
		
		$data = $this->model->fetch_all(array());
		
		if ($_POST)
		{	
			$data  = (array) $_POST + (array) $data;
			
			$data['id'] = $this->model->update(array('var_name' => 'slogan_title', 'var_value' => $data['slogan_title']), NULL);
			$data['id'] = $this->model->update(array('var_name' => 'slogan_subtitle', 'var_value' => $data['slogan_subtitle']), NULL);
			
			
			if($_FILES['slogan_image']['name']):
				$data['id'] = $this->model->update(array('var_name' => 'slogan_image', 'var_value' => $data['slogan_image']), $_FILES);
			endif;
			
			
			Request::current()->redirect($this->_index_action);
		}
		
		$this->template->content->data = $data;
	}


}