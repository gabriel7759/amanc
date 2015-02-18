<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Template extends Controller_Template {
	
	/**
 	* Permisssions constants. See sys_lookup "action" type.
 	*/
	const VIEW   = 1;
	const INSERT = 2;
	const UPDATE = 3;
	const DELETE = 4;
	const STATUS = 5;
	const SORT   = 6;
	const EXPORT   = 7;
	
	/**
 	* Default template view file.
 	*/
	public $template = 'backend/template';
	/**
 	* Default view file.
 	*/
	public $view;
	/**
 	* Items to show per page. Used for pagination.
 	*/
	public $items_per_page = 20;
	/**
 	* Main model used in the current controller. Used to get 
	* the class name of the model for delete, stattus and sort actions.
 	*/
	public $model;
	
	/**
 	* View file path for the current action.
 	*/
	protected $_view_path;
	/**
 	* Module URL for building actions URLs.
 	*/
	protected $_module_url;
	/**
 	* Index action URL path.
 	*/
	protected $_index_action;
	/**
 	* Module ID.
 	*/
	protected $_module_id;
	/**
 	* Action ID. To check permissions.
 	*/
	protected $_action_id;
	/**
 	* User Identity.
 	*/
	protected $_user;
	
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		
		$this->_session    = Session::instance();
		$this->_directory  = Request::$current->directory();
		$this->_controller = Request::$current->controller();
		$this->_action     = Request::$current->action();
		$this->_user       = Auth::instance()->get_user();
		$this->_module_id  = $this->_get_module_id($this->_directory, $this->_controller);
		$this->_action_id  = $this->_get_action_id($this->_action);
		
		$this->_view_path = $this->_directory."/".$this->_controller."/";
		$this->_module_url = URL::base().str_replace("backend/", "admin/", $this->_view_path);
		$this->_index_action = $this->_module_url."index";
	}
	
	public function before()
	{
		// Check session
		if ($this->_controller != 'session')
		{
			if( ! $this->_user OR $this->_user['system'])
				Request::current()->redirect('/admin/start/session/login');
		}
		// Check permission
		if ($this->_directory != 'backend/start')
		{
			if( ! in_array($this->_module_id.'.'.$this->_action_id, $this->_user['permissions']))
				Request::current()->redirect('/admin/start/error/forbidden');
		}
		
		parent::before();
		
		//$this->auto_render = ! $this->request->is_ajax();
		
		if ($this->auto_render)
		{
			$view = ($this->view) ? $this->view : $this->_view_path.Request::$current->action();
			
			if (Kohana::find_file('views', $view))
			{
				if ($this->_controller != 'session')
				{
					$this->template->menu = Model::factory('Sys_Module')->menu($this->_view_path);
					$this->template->title = Model::factory('Sys_Module')->get_title($this->_view_path);
				}
				$this->template->user = $this->_user;
				
				$this->template->content = View::factory($view);
				$this->template->sitename       = Kohana::$config->load('site.sitename');
				$this->template->content->action_list    = $this->_get_action_url('index');
				$this->template->content->action_details = $this->_get_action_url('details');
				$this->template->content->action_add     = $this->_get_action_url('add');
				$this->template->content->action_edit    = $this->_get_action_url('edit');
				$this->template->content->action_delete  = $this->_get_action_url('delete');
				$this->template->content->action_status  = $this->_get_action_url('status');
				$this->template->content->action_sort    = $this->_get_action_url('sort');
				$this->template->content->action_export  = $this->_get_action_url('export');
				
				/*
				Model::factory('Sys_Log_Activity')->check_undo();
				$this->template->success = Model::factory('Sys_Log_Activity')->get_flash_msg('activity_log_id');
				*/
			}
		}
		
	}
	
	public function action_delete()
	{
		if ($_POST)
		{
			$identifier = Arr::get($_POST, 'id');
			foreach ( (array) $identifier as $id)
			{
				$data = $this->model->fetch(array(
					'id' => $id,
				));

//				$this->model->delete($id);
				$this->model->delete($id, $this->_controller);
				$this->_log_activity($id, $data['name'], self::DELETE, array('deleted' => 1));
			}
		}
		Request::current()->redirect($this->_index_action);
	}
	
	public function action_status()
	{
		if ($_POST)
		{
			$identifier = Arr::get($_POST, 'id');
			$status     = Arr::get($_POST, 'status');
			foreach ( (array) $identifier as $id)
			{
				$data = $this->model->fetch(array(
					'id' => $id,
				));
				$this->model->status($id, $status);
				$this->_log_activity($id, $data['name'], self::STATUS, array('status' => $status));
			}
		}
		Request::current()->redirect($this->_index_action);
	}
	
	public function action_sort()
	{
		if ($_POST)
		{
			parse_str($_POST['serialized'], $serialized);
			$this->model->sort($serialized);
		}
		Request::current()->redirect($this->_index_action);
	}
	
	/**
	 * Handle backend routes and map them automatically to the corresponding controller/action.
	 * Example: 
	 *   Route::set('backend', array('Controller_Backend_Template', 'route'));
	 *
	 * @var $uri URI
	 * @return array Directory, Controller, Action
	 */
	public static function route($uri)
	{
		$route   = explode('/', $uri);
		$default = array('admin', 'start', 'overview', 'index');
		
		list($application, $directory, $controller, $action) = $route + $default;
		
		if ($application != 'admin')
			return FALSE;
		
		return array(
			'directory'  => 'backend/'.$directory,
			'controller' => $controller,
			'action'     => $action,
		);
	}
	
	protected function _get_module_id($directory, $controller)
	{
		$directory = str_replace("backend/", "", $directory);
		
		return DB::query(Database::SELECT, "
			SELECT c.id
			FROM sys_module AS c
			LEFT JOIN sys_module AS d ON d.id = c.parent_id
			WHERE d.directory = :directory AND c.directory = :controller
		")
		->parameters(array(
			':directory' => $directory,
			':controller' => $controller,
		))
		->execute()
		->get('id', 0);
	}
	
	protected function _get_action_id($action)
	{
		$code = NULL;
		
		if ($action == 'index' OR $action == 'export' OR $action == 'details')
		{
			$code = 1;
		}
		elseif ($action == 'form' AND ($_GET['id'] OR $_POST['id']))
		{
			$code = 3;
		}
		elseif ($action == 'form')
		{
			$code = 2;
		}
		elseif ($action == 'delete')
		{
			$code = 4;
		}
		elseif ($action == 'status')
		{
			$code = 5;
		}
		elseif ($action == 'sort')
		{
			$code = 6;
		}
		elseif ($action == 'export')
		{
			$code = 7;
		}
		
		return $code;
	}
	
	public function _get_action_url($action)
	{
		if ($this->_user)
		{
			if ($action == 'index' AND in_array($this->_module_id.'.'.self::VIEW, $this->_user['permissions']))	
				return $this->_module_url.'index';
			if ($action == 'add' AND in_array($this->_module_id.'.'.self::INSERT, $this->_user['permissions']))	
				return $this->_module_url.'form';
			if ($action == 'edit' AND in_array($this->_module_id.'.'.self::UPDATE, $this->_user['permissions']))	
				return $this->_module_url.'form';
			if ($action == 'delete' AND in_array($this->_module_id.'.'.self::DELETE, $this->_user['permissions']))	
				return $this->_module_url.'delete';
			if ($action == 'status' AND in_array($this->_module_id.'.'.self::STATUS, $this->_user['permissions']))	
				return $this->_module_url.'status';
			if ($action == 'sort' AND in_array($this->_module_id.'.'.self::SORT, $this->_user['permissions']))	
				return $this->_module_url.'sort';
			if ($action == 'export' AND in_array($this->_module_id.'.'.self::VIEW, $this->_user['permissions']))	
				return $this->_module_url.'export';
			if ($action == 'details' AND in_array($this->_module_id.'.'.self::VIEW, $this->_user['permissions']))	
				return $this->_module_url.'details';
		}
		
		return NULL;
	}
	
	protected function _log_activity($item_id, $item_name, $action, $data)
	{	
		list($log_id) = DB::query(Database::INSERT, "
				INSERT INTO sys_log_activity (user_id, module_id, item_id, item_name, data, action, timestamp)
				VALUES (:user_id, :module_id, :item_id, :item_name, :data, :action, :timestamp)
			")
			->parameters(array(
				':user_id'   => $this->_user['id'],
				':module_id' => $this->_module_id,
				':item_id'   => $item_id,
				':item_name' => $item_name,
				':data'      => json_encode($data),
				':action'    => $action,
				':timestamp' => time(),
			))
			->execute();
		
		$table = strtolower(str_replace('Model_', '', get_class($this->model)));
		
		DB::query(Database::UPDATE, "
				UPDATE ".mysql_real_escape_string($table)." SET log_id = :log_id WHERE id = :id
			")
			->parameters(array(
				':log_id' => $log_id,
				':id'     => $item_id,
			))
			->execute();
		
		//$session->set('activity_log_id', $activity_log_id);
		
		return $log_id;
	}

}