<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Manage_Marathon extends Controller_Backend_Template {
	
	public function before()
	{
		parent::before();
		
		$this->model  = new Model_Marathon;
	}
	
	public function action_index()
	{
		$page     = Arr::get($_GET, 'page', 1);
		$order_by = Arr::get($_GET, 'order_by', 't1.date_marathon');
		$sort     = Arr::get($_GET, 'sort', 'DESC');
		$status   = Arr::get($_GET, 'status', -1);
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
		$tags = Model::factory('Tag')->fetch_all(array('status' => 1));
		$data = $this->model->fetch(array(
			'id' => $id,
		));
		
		if ($_POST){	
			$data  = (array) $_POST + (array) $data;
			$valid = $this->model->validate($data);
			var_dump($_FILES); exit;
			if ( ! $valid->check()){
				$this->template->errors = $valid->errors('news');
			}else{
				if ($data['id']){
					$data['id'] = $this->model->update($data, $_FILES);
					$action = self::UPDATE;
				}else{
					$data['id'] = $this->model->insert($data, $_FILES);
					$action = self::INSERT;
				}
				$this->_log_activity($data['id'], $data['title'], $action, $data);
				Request::current()->redirect($this->_index_action);
			}
		}
		
		$this->template->content->tags = $tags;
		$this->template->content->data = $data;

	}


}