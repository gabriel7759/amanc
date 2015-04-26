<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Actividades extends Controller_Frontend_Template {
	function before(){
		parent::before();
		$this->popular_activities = $this->actividad->get_popular();
		$this->tags = $this->tag->fetch_all(array('status'=>1));
	}
	public function action_por_estado(){
		$items_per_page = 4;
		$num_page = Arr::get($_GET, 'page', 1);
		$offset   = ($num_page - 1) * $items_per_page;

		$data = array();
		$data['estados'] = $this->estado->fetch_all(array());
		$slug = $this->request->param('slug');
		$id_estado = $this->estado->fetch(array('slug'=>$slug));
		$id_estado = $id_estado['id'];
		$data['titulo'] = 'Últimas actividades';
		$data['uri'] = '/actividades';
		if($id_estado){
			$data['info_estado'] = $this->estado->fetch(array('id'=>$id_estado));
			$data['titulo'] = $data['info_estado']?'Actividades en '.$data['info_estado']['state']:'';
			$data['uri'] = '/actividades/estado/'.$id_estado;
		}
		$data['popular'] = $this->popular_activities;
		$data['tags'] = $this->tag->get_by_content(array('module'=>8));
		$data['actividades'] = $this->actividad->fetch_all(array('state_id'=>$id_estado, 'status'=>1, 'order_by'=>'t1.id', 'sort'=>'DESC', 'limit'=>$items_per_page, 'offset'=>$offset));
		
		//Pagination
		$pagination = Pagination::factory(array('total_items' => $data['actividades']->found_rows(), 'items_per_page' => $items_per_page, 'view' => 'frontend/pagination/basic'));	
		$data['pagination'] = $pagination->render();

		$this->template->content = View::factory('frontend/actividades/por_estado')->set('data', $data);
	}
	public function action_por_tag(){
		$items_per_page = 4;
		$num_page = Arr::get($_GET, 'page', 1);
		$offset   = ($num_page - 1) * $items_per_page;

		$data = array();
		$data['estados'] = $this->estado->fetch_all(array());
		$id_tag = $this->request->param('id_tag');
		if($id_tag){
			$data['tag_data'] = $this->tag->fetch(array('id'=>$id_tag));
		}
		$data['popular'] = $this->popular_activities;
		$data['tags'] = $this->tag->get_by_content(array('module'=>8));
		$data['actividades'] = $this->actividad->fetch_all(array('tag_id'=>$id_tag, 'status'=>1, 'order_by'=>'t1.id', 'sort'=>'DESC', 'limit'=>$items_per_page, 'offset'=>$offset));
		
		//Pagination
		$pagination = Pagination::factory(array('total_items' => $data['actividades']->found_rows(), 'items_per_page' => $items_per_page, 'view' => 'frontend/pagination/basic'));	
		$data['pagination'] = $pagination->render();

		$this->template->content = View::factory('frontend/actividades/por_tag')->set('data', $data);
	}
	 public function action_detalle(){
	 	$id_actividad = $this->request->param('id_actividad');
	 	if(!$id_actividad) Request::current()->redirect('/actividades');
	 	$data['actividad'] = $this->actividad->fetch(array('id'=>$id_actividad));
	 	if(!$data['actividad']) Request::current()->redirect('/actividades');
	 	$this->actividad->add_popular($id_actividad);
	 	$data['popular'] = $this->popular_activities;
	 	$data['tags'] = $this->tag->get_by_content(array('module'=>8));
	 	$this->template->content = View::factory('frontend/actividades/detalle')->set('data', $data);
	 }
}
