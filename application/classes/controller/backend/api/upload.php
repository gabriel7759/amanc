<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Api_Upload extends Controller { 

	var	$_session    = "";
	var	$_directory  = "";
	var	$_controller = "";
	var	$_action     = "";
	var	$_user       = "";

	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		
		$this->_session    = Session::instance();
		$this->_directory  = Request::$current->directory();
		$this->_controller = Request::$current->controller();
		$this->_action     = Request::$current->action();
		$this->_user       = Auth::instance()->get_user();
		
	}

	public function before()
	{
		// Check session
		if ($this->_controller != 'session')
		{
			if( ! $this->_user OR $this->_user['system'])
				Request::current()->redirect('/admin/start/session/login');
		}
		
		parent::before();
		
		if (Kohana::$environment == Kohana::DEVELOPMENT)
		{
			$this->response->headers('Access-Control-Allow-Origin', '*');
			$this->response->headers('Access-Control-Allowed-Methods', 'PUT,POST,GET,OPTIONS');
		}
//		$this->response->headers('Content-Type', 'application/json');
		$this->response->headers('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
	}
	
	public function action_image()
	{
		$url = "";
		$funcNum = Arr::get($_GET, 'CKEditorFuncNum', 3);
		$result = array(
			'error'=>true,
			'errordesc'=>'No file received',
			'original'=>'',
			'original_wpath'=>'',
		);

		$folder = '/assets/files/content/';
		$route = $folder;

		if ($_FILES)
		{
				
			$folder = substr($folder, 1);
			
			// Validate file
			$myimg = Validation::factory($_FILES)
				->rule('image', 'Upload::type', array(':value', array('jpg', 'png', 'gif')))
				->rule('image', 'Upload::image')
				->rule('image', 'Upload::not_empty')
				->rule('image', 'Upload::valid');
				// Save image
			$myimg = Upload::save($myimg['upload'], NULL, $folder);
					
			// Check if file uploaded
			if($myimg !== FALSE){
				$result['error'] = false;
				$result['errordesc'] = '';
				$result['original_wpathfull'] = str_replace($_SERVER['DOCUMENT_ROOT'], '', $myimg);
				$result['original_wpath'] = $route.basename($result['original_wpathfull']);
				$result['original'] = basename($result['original_wpathfull']);
			}
		}

		$response = "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(".$funcNum.", '".$result['original_wpath']."', '".$result['errordesc']."');</script>";

//		$this->request->headers['Content-Type'] = 'application/json';
		$this->response->body($response);

	}
	
}