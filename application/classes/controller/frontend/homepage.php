<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Homepage extends Controller_Frontend_Template {
	
	public function action_index()
	{
		$this->template->is_home = true;
		
		$view = View::factory('frontend/homepage/index')
			->set('state', Model::factory('State')->fetch_all(array()))
			->set('activities', Model::factory('Activity')->fetch_all(array('order_by' => 't1.id', 'sort' => 'DESC', 'offset' => 0, 'limit' => 7)))
			->set('projects', Model::factory('Project')->fetch_all(array('order_by' => 'project.id', 'sort' => 'DESC', 'offset' => 0, 'limit' => 5)))
			->set('news', Model::factory('News')->fetch_all(array('order_by' => 'news.newsdate', 'sort' => 'DESC', 'offset' => 0, 'limit' => 4)))
			->set('slide', Model::factory('Slide')->fetch_active())
			->set('partner', Model::factory('Partner')->fetch_all( array('status' => 1, 'order_by' => 'partner.position', 'sort' => 'ASC') ))
			->set('siteconfig', Model::factory('Siteconfig')->fetch_all(array()));
		$this->template->content = $view;
	}

	public function action_register()
	{				
		
		$this->template->errors = "";
		if($_POST):
		
			$data['status'] = 0;
			$data = array_merge( (array) $data, $_POST);
			
			$valid = Model::factory('Userfront')->validate($data);
		
			//if(1==2)
			if ( ! $valid->check())
			{
				$this->template->errors = $valid->errors('page');
			}
			else
			{
				$ins = Model::factory('Userfront')->insert($data);
				Request::current()->redirect('registrofin');	
			}			
						
		endif;
		
		$view = View::factory('frontend/homepage/register')
			->set('data', $data)
			->set('errors', $this->template->errors)
			->set('licencetype', Model::factory('Licencetype')->fetch_all(array('order_by' => 'licencetype.id', 'sort' => 'ASC')))
			->set('siteconfig', Model::factory('Siteconfig')->fetch_all(array()));
		$this->template->content = $view;
	}

	public function action_registerend()
	{
		$view = View::factory('frontend/homepage/registerend')
			->set('siteconfig', Model::factory('Siteconfig')->fetch_all(array()));
		$this->template->content = $view;
	}
	
	public function action_vencido()
	{
		$user_front = $this->template->user_front;
		
		$view = View::factory('frontend/homepage/vencido')
			->set('user_front', $user_front)
			->set('siteconfig', Model::factory('Siteconfig')->fetch_all(array()));
		$this->template->content = $view;
	}
	
	public function action_noactivo()
	{
		$view = View::factory('frontend/homepage/noactivo')
			->set('siteconfig', Model::factory('Siteconfig')->fetch_all(array()));
		$this->template->content = $view;
	}

	public function action_content()
	{
		$section = $this->request->param('section');
		$page = $this->request->param('page');
		$subpage = $this->request->param('subpage');
		
		$data = Model::factory('Content')->fetchbyuri($section, $page, $subpage);
		$this->template->title = " | ".$data['title'];
		
		$data['galleries'] = Model::factory('Gallery')->fetch_all(array(
			//'limit'    => $this->items_per_page,
			//'offset'   => $offset,
			'order_by' => 'gallery.position',
			'sort'     =>'ASC',
			'status'   => 1,
			'content_id' => 14,
			//'text'     => $text,
			//'id_medico' => $id_medico,
		))->as_array(); 
		$i=0;
		foreach($data['galleries'] as $gallery){
			$images=Model::factory('Gallery')->fetch_gallery($gallery['id']);
			if($images['gallery_id']==$gallery_id['id'])
				$data['galleries'][$i]['images']= $images;
			$i++;
		} 
		//var_dump($data['galleries']); exit;
		$view = View::factory('frontend/homepage/content')
			->set('data', $data);
		$this->template->content = $view;
	}

	public function action_contact()
	{
		$sent = FALSE;

		if($_POST){
			$sent = Model::factory('Contact')->send($_POST);
		}
		
?>
	<script type="text/javascript">
    	alert('mensaje enviado con éxito');
		window.location.href= 'index';
    </script>

<?php		
		
		/*$section = "contacto";
		$page = "";
		$subpage = "";

		$this->template->title = " | Contacto";

		$view = View::factory('frontend/homepage/contact')
			->set('data', Model::factory('Content')->fetchbyuri($section, $page, $subpage))
			->set('areas', Model::factory('Contactarea')->fetch_active())
			->set('sent', $sent);
		$this->template->content = $view;*/
	}


}