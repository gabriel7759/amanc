<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Privado extends Controller_Frontend_Template {
	
	
	public function action_login()
	{
		
		$login = Model::factory('Userfront')->login($_POST);
		
		
		if($login==1):
			Request::current()->redirect('privado/proyectos');
		elseif($login==2):
			Request::current()->redirect('noactivo');
		elseif($login==3):
			Request::current()->redirect('vencido');
		else:
		?>
			<script type="text/javascript">
				alert('El usuario o contraseña son incorrectos');
				window.location.href='/index';
			</script>
        <?php
		endif;	
		
	}
	
	public function action_logout()
	{
		Model::factory('Userfront')->logout();
		Request::current()->redirect('index');
		
	}
	
	public function action_profile()
	{
		$user_front = $this->template->user_front;	
		$data = Model::factory('Userfront')->fetch(array('id' => $user_front['id']));
		
		
		$view = View::factory('frontend/privado/profile')
			->set('data', $data)
			->set('siteconfig', Model::factory('Siteconfig')->fetch_all(array()));
		$this->template->content = $view;
	}
	
	public function action_editprofile()
	{
		$user_front = $this->template->user_front;
		$data = Model::factory('Userfront')->fetch(array('id' => $user_front['id']));
		
		$this->template->errors = "";
		if($_POST):
		
			$data['status'] = 1;
			$data = array_merge( (array) $data, $_POST);
			
			$valid = Model::factory('Userfront')->validateup($data);
		
			//if(1==2)
			if ( ! $valid->check())
			{
				$this->template->errors = $valid->errors('page');
			}
			else
			{
				$ins = Model::factory('Userfront')->update($data);
				Request::current()->redirect('editprofilefin');	
			}			
						
		endif;
		
		$view = View::factory('frontend/privado/editprofile')
			->set('data', $data)
			->set('errors', $this->template->errors)
			->set('licencetype', Model::factory('Licencetype')->fetch_all(array('order_by' => 'licencetype.id', 'sort' => 'ASC', 'great_than' => 1)))
			->set('siteconfig', Model::factory('Siteconfig')->fetch_all(array()));
		$this->template->content = $view;
	}
	
	public function action_editprofilefin()
	{
		$view = View::factory('frontend/privado/editprofilefin')
			->set('siteconfig', Model::factory('Siteconfig')->fetch_all(array()));
		$this->template->content = $view;
	}

	public function action_projects()
	{

		$this->template->title = " | Proyectos ";
		$user_front            = $this->template->user_front;
		
		//var_dump($user_front);
		
		$chk  = Model::factory('userfront')->check_sess(array('id' => $user_front['licence_id']));
		$days = Model::factory('userfront')->check_days(array('id' => $user_front['licence_id']));
		
		if(!$chk)
		{
			
			if($days>0)
			{
				Request::current()->redirect('privado/logout');
			}
			else
			{
				Request::current()->redirect('vencido');
			}
			
		}
		
		if($user_front)
		{
			$user_id = $user_front['id'];
		} 
		else
		{
			$user_id = 0;
		}
		
		$projects_recent = Model::factory('Project')->fetch_all(array('user_id' =>$user_id, 'offset' => 0, 'limit' => 4, 'order_by' => 'project.date_created', 'sort' => 'DESC'));
		$projects        = Model::factory('Project')->fetch_all(array('user_id' =>$user_id, 'order_by' => 'project.date_created', 'sort' => 'DESC'));

		$view = View::factory('frontend/privado/proyectos')
			->set('user_front', $user_front)
			->set('projects_recent', $projects_recent)
			->set('projects', $projects);
		$this->template->content = $view;	
		
	}
	
	public function action_project()
	{

		$this->template->title = " | Proyectos ";
		$user_front            = $this->template->user_front;
		$project_id            = $this->request->param('project_id');
		$step_id               = $this->request->param('step_id');
		
		//echo "->".time();
		
		$locations      	  = Model::factory('Location')->fetch_all(array('order_by' => 'location.slot', 'sort' => 'ASC', 'parent_id' => 0));
		$services       	  = Model::factory('Service')->fetch_all(array('order_by' => 'service.slot', 'sort' => 'ASC'));
		$bestpractices  	  = Model::factory('Bestpractice')->fetch_all(array('order_by' => 'bestpractice.slot', 'sort' => 'ASC'));
		$densification_tip    = Model::factory('Densification')->fetch_all(array('order_by' => 'densification.slot', 'sort' => 'ASC', 'parent_id' => 1));
		$densification_dens   = Model::factory('Densification')->fetch_all(array('order_by' => 'densification.slot', 'sort' => 'ASC', 'parent_id' => 4));
		$competivity		  = Model::factory('Competivity')->fetch_all(array('order_by' => 'competivity.slot', 'sort' => 'ASC'));
		$get_project    	  = Model::factory('Project')->fetch(array('user_id' =>$user_front['id'], 'project_id' => $project_id, 'step_id' => $step_id));
		
		Session::instance()->set('project', $get_project);
		$project = Session::instance()->get('project');

		//echo "<pre>";
		//var_dump($project);
		//echo "</pre>";
		//exit;

		//var_dump($locations);
		
		$view = View::factory('frontend/privado/proyecto'.$step_id)
			->set('user_front', $user_front)
			->set('locations', $locations)
			->set('services', $services)
			->set('densification_tip', $densification_tip)
			->set('densification_dens', $densification_dens)
			->set('competivity', $competivity)
			->set('bestpractices', $bestpractices)
			->set('project', $project);
		$this->template->content = $view;	
		
	}
	
	public function action_excel()
	{

		$this->template->title = " | Proyectos ";
		$user_front            = $this->template->user_front;
		$project_id            = $this->request->param('project_id');
		
		$project    	  = Model::factory('Project')->fetch(array('user_id' =>$user_front['id'], 'project_id' => $project_id));
		
	
		
		header('Content-Type: application/excel; charset=UTF8');
		header('Content-Disposition: attachment; filename="project.'.time()."_".$project_id.'.xls"');
		
		$export .= '<table>
						<tr>
							<td align="right"><strong>Proyecto</strong></td>
							<td><strong>'.$project['title'].'</strong></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><strong>Puntaje</strong></td>
							<td>'.$project['points'].'</td>
						</tr>
						<tr>
							<td align="right"><strong>Valor de la vivienda</strong></td>
							<td>$'.number_format($project['cost'],2).'</td>
						</tr>
						<tr>
							<td align="right"><strong>Monto de subsidio</strong></td>
							<td>'.number_format($project['subsidio'],2).'</td>
						</tr>
						<tr>
							<td align="right" valign="top"><strong>Resumen</strong></td>
							<td>';
		
		if(count($project['detail'] )):
			foreach($project['detail'] as $row):
						$export .= '<p><strong>'.$row['step'].'</strong><br /> '.$row['title'].'-<b>'.$row['points'].' puntos</b></p>';
			endforeach;
		endif;
		
        $export .= '		</td>
                        </tr>
                    </table>';

		echo $export;			
		exit;
		
		/*$view = View::factory('frontend/privado/excel')
			->set('user_front', $user_front)
			->set('locations', $locations)
			->set('services', $services)
			->set('densification_tip', $densification_tip)
			->set('densification_dens', $densification_dens)
			->set('competivity', $competivity)
			->set('bestpractices', $bestpractices)
			->set('project', $project);
		$this->template->content = $view;*/	
		
	}
	
	public function action_saveproject()
	{
		
		$user_front      = Session::instance()->get('identity_front');
		$data['user_id'] = $user_front['id'];
		$project = Session::instance()->get('project');
		
		$data  = (array) $_POST + (array) $data;
		
		if ($data['project_id'])
		{
			$data['project_id'] = Model::factory('Project')->update($data);
		}
		else
		{
			$data['project_id'] = Model::factory('Project')->insert($data);
		}			
		
		Request::current()->redirect('privado/proyecto/'.$data['project_id'].'/'.$data['next_step']);
		
		//echo json_encode(array('project_id' => $data['project_id']));
		//exit;
		
	}
	
	public function action_docalc ()
	{
		$data  = (array) $_POST + (array) $data;
		
		$data['result'] = Model::factory('Project')->docalc($data);
		
		echo json_encode($data['result']);
	}
	
	public function action_docalcdens ()
	{
		$data  = (array) $_POST + (array) $data;
		
		$data['result'] = Model::factory('Project')->docalcdens($data);
		
		echo json_encode($data['result']);
	}
	
	public function action_docalcvalue ()
	{
		$data  = (array) $_POST + (array) $data;
		
		$data['result'] = Model::factory('Project')->docalcvalue($data);
		
		echo json_encode($data['result']);
	}
	
	public function calculate_string( $string )    {
	    $string = trim($string);
    	$string = preg_replace('/[^0-9\+\-\*\/\(\) ]/i', '', $string);
	    $compute = create_function('', 'return (' . $string . ');' );
	    return 0 + $compute();
	}

}