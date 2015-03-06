<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Manage_gallery extends Controller_Backend_Template {
	
	public function before()
	{
		parent::before();
		
		$this->model  = new Model_Gallery;
		$this->model_content = Model::factory('content');
	}
	
	public function action_index()
	{
		$page     = Arr::get($_GET, 'page', 1);
		$order_by = Arr::get($_GET, 'order_by', 'gallery.position');
		$sort     = Arr::get($_GET, 'sort', 'ASC');
		$status   = Arr::get($_GET, 'status', 1);
		$text     = Arr::get($_GET, 'text', '');
		$offset   = ($page - 1) * $this->items_per_page;
		
		$this->template->content->data = $this->model->fetch_all(array(
			'limit'    => $this->items_per_page,
			'offset'   => $offset,
			'order_by' => $order_by,
			'sort'     => $sort,
			'status'   => $status,
			'text'     => $text,
			'id_medico' => $id_medico,
		));
		
		$pagination = Pagination::factory(array(
			'total_items'    => $this->template->content->data->found_rows(),
			'items_per_page' => $this->items_per_page,
		));
		//var_dump($this->template->content->data->as_array()); exit; 
		$this->template->content->page       = $page;
		$this->template->content->order_by   = $order_by;
		$this->template->content->sort       = $sort;
		$this->template->content->status     = $status;
		$this->template->content->text       = $text;
		$this->template->content->page_links = $pagination->render();
	}
	
	public function action_form()
	{
		$id = Arr::get($_GET, 'id', 0);
		$parent_id = Arr::get($_GET, 'parent_id', 0);
		$data = $this->model->fetch(array(
			'id' => $id,
		)); 
		if(!file_exists('assets/files/tmp/')) mkdir('assets/files/tmp/', 0777);
			if(count($_FILES['picture']['name'])>0){
				for ($i=0; $i<count($_FILES['picture']['name'] ); $i++){
					$source = $_FILES['picture']['tmp_name'][$i];           
					$target = "assets/files/tmp/".$_FILES['picture']['name'][$i]; 
					move_uploaded_file($source,$target);
					$_POST['gallery-file']=$_FILES['picture']['name']; 
				}
			}
		//var_dump($_POST); EXIT;
		if ($_POST)
		{	
			
	
			$data  = (array) $_POST + (array) $data;
			$valid = $this->model->validate($data);
		
			if ( ! $valid->check())
			{
				$this->template->errors = $valid->errors('gallery');
			}
			else
			{	
				$data['title']= Arr::get($data,'title',0);
				$data['summary']= Arr::get($data,'summary',0);
				$data['content_id']= Arr::get($data,'content_id',0);
				$data['status']= Arr::get($data,'status',0);
				
				
				
				if ($data['id'])
				{
					$data['id'] = $this->model->update($data, $_FILES);
					$action = self::UPDATE;
				}
				else
				{
					$data['id'] = $this->model->insert($data, $_FILES);
					$action = self::INSERT;
				}
				$this->_log_activity($data['id'], $data['title'], $action, $data);
				
				Request::current()->redirect($this->_index_action);
			}
		}
		
		$this->template->content->data = $data;
		$this->template->content->sections = $this->model_content->get_sections();

	}


}