<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contento Backend Access Admins controller.
 *
 * @package    Contento/Backend
 * @category   Controllers
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Controller_Backend_Access_Roles extends Controller_Backend_Template {
	
	public function before()
	{
		parent::before();
		
		$this->model = new Model_Sys_Role;
	}
	
	public function action_index()
	{
		$page     = Arr::get($_GET, 'page', 1);
		$order_by = Arr::get($_GET, 'order_by', 'sys_role.name');
		$sort     = Arr::get($_GET, 'sort', 'ASC');
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
		));
		
		$pagination = Pagination::factory(array(
			'total_items'    => $this->template->content->data->found_rows(),
			'items_per_page' => $this->items_per_page,
		));
		
		$this->template->add_button = TRUE;
		$this->template->content->page = $page;
		$this->template->content->order_by = $order_by;
		$this->template->content->sort = $sort;
		$this->template->content->status = $status;
		$this->template->content->text = $text;
		$this->template->content->page_links = $pagination->render();
	}
	
	public function action_form()
	{
		$id = Arr::get($_GET, 'id', 0);
		$data = $this->model->fetch(array(
			'id' => $id,
		));
		
		if ($_POST)
		{
			$data  = (array) $_POST + (array) $data;
			$valid = $this->model->validate($data);
		
			if ( ! $valid->check())
			{
				$this->template->errors = $valid->errors('sys_role');
			}
			else
			{
				$data['status'] = Arr::get($data, 'status', 0);
				
				if ($data['id'])
				{
					$data['id'] = $this->model->update($data);
					$action = self::UPDATE;
				}
				else
				{
					$data['id'] = $this->model->insert($data);
					$action = self::INSERT;
				}
				$this->_log_activity($data['id'], $data['name'], $action, $data);
				
				Request::current()->redirect($this->_index_action);
			}
		}
		
		$this->template->content->data    = $data;
		$this->template->content->modules = Model::factory('Sys_Module')->get_list();
	}

}