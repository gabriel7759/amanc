<?php defined('SYSPATH') or die('No direct script access.');

class Model_Voluntario extends Model {
	public function obtener_voluntario($data, $fields=''){
		$p = array();
		$where = '';
		if($data['id']){
			$where .= 'AND id=:id';
			$p[':id'] = $data['id'];
		}
		if($data['email']){
			$where .= 'AND email=:email';
			$p[':email'] = $data['email'];
		}
		if(strlen($where)>0){
			$result = DB::query(Database::SELECT, "
							SELECT 
								id, name, lastname, email ".$fields."
							FROM 
								volunteer
							WHERE 
								1 ".$where."
						")
						->parameters($p)
						->execute()
						->current();
			return $result;
		}
		return false;
	}
	public function agregar_voluntario($data){
		if($data['birthday']){
			$exp_data = explode('-', $data['birthday']);
			$data['birthday'] = $exp_data[2].'-'.$exp_data[1].'-'.$exp_data[0];
		}
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO volunteer (
						type_id,
						name,
						lastname,
						address,
						gender,
						phone,
						email,
						birthday,
						language,
						cancer_related,
						cancer_related_txt,
						hours,
						monday_hrs,
						tuesday_hrs,
						wednesday_hrs,
						thursday_hrs,
						friday_hrs,
						saturday_hrs,
						sunday_hrs,
						interest,
						why,
						datecreated,
						status,
						is_deleted
					) 
				VALUES (
						:type_id,
						:name,
						:lastname,
						:address,
						:gender,
						:phone,
						:email,
						:birthday,
						:language,
						:cancer_related,
						:cancer_related_txt,
						:hours,
						:monday_hrs,
						:tuesday_hrs,
						:wednesday_hrs,
						:thursday_hrs,
						:friday_hrs,
						:saturday_hrs,
						:sunday_hrs,
						:interest,
						:why,
						:datecreated,
						:status,
						:is_deleted
					)
			")
			->parameters(array(
				':type_id'     => $data['type_id'],
				':name'     => $data['name'],
				':lastname'     => $data['lastname'],
				':address'     => $data['address'],
				':gender'     => $data['gender'],
				':phone'     => $data['phone'],
				':email'     => $data['email'],
				':birthday'     => $data['birthday'],
				':language'     => $data['language'],
				':cancer_related'     => $data['cancer_related'],
				':cancer_related_txt'     => $data['cancer_related_txt'],
				':hours'     => $data['hours'],
				':monday_hrs'     => $data['monday_hrs'],
				':tuesday_hrs'     => $data['tuesday_hrs'],
				':wednesday_hrs'     => $data['wednesday_hrs'],
				':thursday_hrs'     => $data['thursday_hrs'],
				':friday_hrs'     => $data['friday_hrs'],
				':saturday_hrs'     => $data['saturday_hrs'],
				':sunday_hrs'     => $data['sunday_hrs'],
				':interest'     => $data['interest'],
				':why'     => $data['why'],
				':datecreated'     => strtotime($data['datecreated']),
				':status'     => 1,
				':is_deleted'     => 0,
			))
			->execute();
		return $id;
	}

}