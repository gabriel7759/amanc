<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Frontend_Ajax extends Controller_Frontend_Template {
	public function before(){
		parent::before();
	}
	function action_save_volunteer(){
		if($_POST&&$_POST['send']){
			parse_str($_POST['data'], $data);
			//print '<pre>'; var_dump($data); print '</pre>'; exit;
			foreach($data as $k => $v){ if(!is_array($v)) $data[$k] = strip_tags(addslashes(Kohana::sanitize($v))); }
			$error = false;
			foreach($data as $v){ 
				if(empty($v)){
					$error=true;
				}  
			}
			if(!$error){
				if(!$this->voluntario->obtener_voluntario(array('email'=>$data['email']))){
					$inserted = $this->voluntario->agregar_voluntario($data);
					if($inserted) print 'ok';
						else print 'Ocurrió un error al registrarse, por favor, intente más tarde.';
					exit;
				}else print 'Ya hay un voluntario registrado con la cuenta de correo que ingresó';
			}else print 'Debe completar todos los campos.';
		}else print 'Error al enviar el formulario.';
		exit;
	}
}