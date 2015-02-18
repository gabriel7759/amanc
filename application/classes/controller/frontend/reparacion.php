<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Reparacion extends Controller_Frontend_Template {
	
	
	public function action_index()
	{
		$section = 'servicios';
		$page = 'solicitud-de-servicio';
		$subpage = "";

		$content = Model::factory('Content')->fetchbyuri($section, $page, $subpage);
		$this->template->title = " | ".$content['title'];

		$view = View::factory('frontend/reparacion/index')
			->set('data', $content)
			->set('categories', Model::factory('Catcategory')->fetch_active());
		$this->template->content = $view;
	}

	public function action_equipo()
	{
		if($_POST){
			$fails = Model::factory('catfailure')->fetch_group($_POST['failure']);
		}
		
		$section = 'servicios';
		$page = 'solicitud-de-servicio';
		$subpage = "";

		$content = Model::factory('Content')->fetchbyuri($section, $page, $subpage);
		$this->template->title = " | ".$content['title'];

		$view = View::factory('frontend/reparacion/equipo')
			->set('data', Model::factory('Content')->fetchbyuri($section, $page, $subpage))
			->set('brands', Model::factory('Catbrand')->fetch_byfailure($_POST['failure']))
			->set('fails', $fails);
//			->set('areas', Model::factory('Contactarea')->fetch_active());
		$this->template->content = $view;
	}

	public function action_precotizacion()
	{
		if($_POST){
			$fails = Model::factory('catfailureprice')->fetch_group($_POST);
			$precotizacion = Model::factory('Solicitudes')->pre($_POST, $fails);
		}
		
		$section = 'servicios';
		$page = 'solicitud-de-servicio';
		$subpage = "";

		$content = Model::factory('Content')->fetchbyuri($section, $page, $subpage);
		$this->template->title = " | ".$content['title'];

		$view = View::factory('frontend/reparacion/precotizacion')
			->set('fails', $fails)
			->set('data', $_POST)
			->set('content', $content)
			->set('preid', $precotizacion);
//			->set('areas', Model::factory('Contactarea')->fetch_active());
		$this->template->content = $view;
	}

	public function action_solicitud()
	{
		if($_POST){
			$fails = Model::factory('catfailureprice')->fetch_group($_POST);
			$fails2 = Model::factory('catfailure')->fetch_group($_POST['failure']);
		}
		
		$section = 'servicios';
		$page = 'solicitud-de-servicio';
		$subpage = "";

		$content = Model::factory('Content')->fetchbyuri($section, $page, $subpage);
		$this->template->title = " | ".$content['title'];

		$view = View::factory('frontend/reparacion/solicitud')
			->set('brand', Model::factory('Catbrand')->fetch(array('id'=>$_POST['brand'])))
			->set('model', Model::factory('Catmodel')->fetch(array('id'=>$_POST['model'])))
			->set('fails', $fails)
			->set('fails2', $fails2)
			->set('content', $content)
			->set('states', Model::factory('States')->fetch_all())
			->set('colores', Model::factory('Colores')->fetch_all())
			->set('condiciones', Model::factory('Condiciones')->fetch_all())
			->set('data', $_POST);
//			->set('areas', Model::factory('Contactarea')->fetch_active());
		$this->template->content = $view;
	}

	public function action_genera()
	{
		if($_POST){
			$fails = Model::factory('catfailureprice')->fetch_group($_POST);
			Model::factory('Solicitudes')->update($_POST, $_FILES, $fails);
		}
		
		$section = 'servicios';
		$page = 'solicitud-de-servicio';
		$subpage = "";

		$content = Model::factory('Content')->fetchbyuri($section, $page, $subpage);
		$this->template->title = " | ".$content['title'];

		$view = View::factory('frontend/reparacion/genera')
			->set('content', $content)
			->set('data', Model::factory('Solicitudes')->fetch($_POST['preid']));

		$this->template->content = $view;
	}

	public function action_confirmacion()
	{
		$section = 'servicios';
		$page = 'solicitud-de-servicio';
		$subpage = "";

		$content = Model::factory('Content')->fetchbyuri($section, $page, $subpage);
		$this->template->title = " | ".$content['title'];

		$view = View::factory('frontend/reparacion/confirmacion')
			->set('content', $content);

		$this->template->content = $view;
	}


}