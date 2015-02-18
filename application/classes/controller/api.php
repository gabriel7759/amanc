<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller {

	public function before()
	{
		parent::before();
		
		if (Kohana::$environment == Kohana::DEVELOPMENT)
		{
			$this->response->headers('Access-Control-Allow-Origin', '*');
			$this->response->headers('Access-Control-Allowed-Methods', 'PUT,POST,GET,OPTIONS');
		}
		$this->response->headers('Content-Type', 'application/json');
		$this->response->headers('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
	}

	public function action_register()
	{
		$result = array("success"=>FALSE, "error"=>TRUE, "errordesc"=>"No data received", "id"=>0);
		$data = NULL;

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			$res = Model::factory('Registrations')->insert($data);
			if($res){
				$result['success'] = TRUE;
				$result['error'] = FALSE;
				$result['errordesc'] = "";
				$result['id'] = $res;
			}
		}
		
		$response = json_encode($result);
		
		$this->response->body($response);
	}

	public function action_loadModels()
	{
		$result = array();
		$data = NULL;

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			if(isset($data['fails']))
				$result = Model::factory('catmodel')->fetch_bybrandfails($data['id'], $data['fails']);
			else
				$result = Model::factory('catmodel')->fetch_bybrand($data['id']);
		}
		
		$response = json_encode($result);
		
		$this->response->body($response);
	}

	public function action_loadAddress()
	{
		$result = array();
		$data = NULL;

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			$result = Model::factory('Zips')->fetch_zip($data['zip']);
		}
		
		$response = json_encode($result);
		
		$this->response->body($response);
	}

	public function action_loadMunicipios()
	{
		$result = array();
		$data = NULL;

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			$result = Model::factory('Zips')->fetch_municipios(Arr::get($data, 'estado', 0));
		}
		
		$response = json_encode($result);
		
		$this->response->body($response);
	}

	public function action_loadColonias()
	{
		$result = array();
		$data = NULL;

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			$result = Model::factory('Zips')->fetch_colonias(Arr::get($data, 'municipio', 0));
		}
		
		$response = json_encode($result);
		
		$this->response->body($response);
	}

	public function action_loadZip()
	{
		$result = array();
		$data = NULL;

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			$result = Model::factory('Zips')->fetch_uzip(Arr::get($data, 'colonia', 0));
		}
		
		$response = json_encode($result);
		
		$this->response->body($response);
	}

	public function action_loadModelsAll()
	{
		$result = array();
		$data = NULL;

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			$result = Model::factory('catmodel')->fetch_bybrandall($data['id']);
		}
		
		$response = json_encode($result);
		
		$this->response->body($response);
	}

	public function action_loadFailsByType()
	{
		$result = array();
		$data = NULL;

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			$result = Model::factory('Catfailure')->fetch_all(array("sort"=>'ASC', 'parent_id'=>$data['section_id'], 'failuretype_id'=>$data['type_id']))->as_array();
		}
		
		$response = json_encode($result);
		
		$this->response->body($response);
	}

	public function action_loadContent()
	{
		$result = array();
		$data = NULL;

		$data = array_merge( (array) $data, $_GET);
		$result = Model::factory('Content')->fetchbyuri($data['url'], '', '');
		
		$response = json_encode($result);
		
		$this->response->body($response);
	}

	public function action_notify()
	{
		$result = array();
		$data = NULL;

		$data = array_merge( (array) $data, $_POST, $_GET);
		Model::factory('Solicitudes')->notify($data);
		$this->response->body('');
	}

	public function action_uploadify()
	{

		$result = array(
			'error'=>true,
			'errordesc'=>'No file received',
			'original'=>'',
			'original_wpath'=>'',
			'medium'=>'',
			'medium_wpath'=>'',
			'thumb'=>'',
			'thumb_wpath'=>''
		);

		$folder = Arr::get($_POST, 'folder', '/assets/files/');

		if ($_FILES)
		{
			
			$folder = substr($folder, 1);
			
			// Validate file
			$myimg = Validation::factory($_FILES)
				->rule('fileupload', 'Upload::type', array(':value', array('jpg', 'png', 'gif')))
				->rule('fileupload', 'Upload::image')
				->rule('fileupload', 'Upload::not_empty')
				->rule('fileupload', 'Upload::valid');
				// Save image
				$myimg = Upload::save($myimg['fileupload'], NULL, $folder);
				
				$result['tmp'] = $myimg;
	
			// Check if file uploaded
			if($myimg !== FALSE){
				
				$result['error'] = false;
				$result['errordesc'] = '';
				$result['original_wpath'] = str_replace($_SERVER['DOCUMENT_ROOT'], '', $myimg);
				$result['original'] = basename($result['original_wpath']);

				// Create thumbnail
				$myThumb = Model::factory('Image')
					->set('image', $myimg)
					->set('maxWidth', Arr::get($_POST, 'thumbWidth', 60))
					->set('maxHeight', Arr::get($_POST, 'thumbHeight', 40))
					->set('target', $folder.'thumb/')
					->create_thumbnail();
					$result['thumb_wpath'] = $myThumb;
					$result['thumb'] = basename($result['thumb_wpath']);
					
			}

		}
		$response = json_encode($result);
		
		$this->request->headers['Content-Type'] = 'application/json';
		$this->response->body($response);

	}
	
}