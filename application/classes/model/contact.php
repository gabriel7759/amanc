<?php defined('SYSPATH') or die('No direct script access.');

class Model_Contact extends Model {
	
	public function fetch_all($params)
	{
		$sql   = "";
		$limit = "";
		$parameters = array();
		
		if ( ! in_array($params['order_by'], array('contact.contactdate')) )
			throw new Kohana_Exception('"'.$params['order_by']. '" is an invalid column for sorting results.');
			
		if ( ! in_array($params['sort'], array('ASC', 'DESC', 'RAND()')) )
			throw new Kohana_Exception('"sort" param must be either ASC, DESC or RAND(). "'.$params['sort'].'" given.');
		
		if (ctype_digit( (string) $params['status']))
		{
			$sql .= " AND contact.status = :status";
			$parameters[':status'] = $params['status'];
		}
		if (ctype_digit( (string) $params['limit']) AND ctype_digit( (string) $params['offset']))
		{
			$limit = "LIMIT :offset, :limit";
			$parameters[':offset'] = $params['offset'];
			$parameters[':limit']  = $params['limit'];
		}
		
		return DB::query(Database::SELECT, "
				SELECT SQL_CALC_FOUND_ROWS 
					contact.id, 
					contact.name, 
					contact.email, 
					contact.contactdate, 
					sys_lookup.name AS status, 
					IF(contact.status=0, 'inactive', '') AS mode
				FROM 
					contact
				LEFT JOIN 
					sys_lookup ON sys_lookup.code = contact.status AND sys_lookup.type = 'status'
				WHERE 
					contact.is_deleted = 0 
					".$sql."
				ORDER BY ".$params['order_by']." ".$params['sort']."
				".$limit."
			")
			->parameters($parameters)
			->execute();
	}

	public function fetch($params)
	{
		$sql = "";
		$parameters = array();

		if (ctype_digit( (string) $params['id']))
		{
			$sql .= " AND contact.id = :id";
			$parameters[':id'] = $params['id'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT 
					contact.id, 
					contact.name, 
					contact.email, 
					contact.phone, 
					contact.contactdate, 
					contact.area_id, 
					contact.message, 
					contactarea.title as area, 
					contact.log_id,
					IF(contact.status=0, 'inactive', '') AS mode
				FROM 
					contact
					LEFT JOIN contactarea ON contactarea.id = contact.area_id
				WHERE 
					contact.is_deleted = 0 
					".$sql."
				LIMIT 1
			")
			->parameters($parameters)
			->execute()
			->current();
		
		if ($data)
		{
			$log  = Model::factory('Sys_Log_Activity')->last_modified($data['log_id']);
			$data = (array) $data + (array) $log;
			$data['date_created'] = Timestamp::format($data['date_created'], '%d/%b/%y %H:%M:%S');
		}
		
		return $data;
	}

	public function fetch_active()
	{
		
		return DB::query(Database::SELECT, "
				SELECT 
					contact.id, 
					contact.title, 
					contact.title as name, 
					contact.email
				FROM 
					contact
				WHERE 
					contact.is_deleted = 0 
					AND contact.status = 1
				ORDER BY
					contact.position ASC
			")
			->execute()
			->as_array();
		
	}


	public function send($data)
	{	
		
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO contact (name, email, phone, area_id, message, contactdate, status, is_deleted, log_id) 
				VALUES (:name, :email, :phone, :area_id, :message, :contactdate, 1, 0, 0)
			")
			->parameters(array(
				':name'    => $data['contact_name'], 
				':email'    => $data['contact_email'], 
				':phone'    => $data['contact_phone'], 
				':area_id'    => $data['area'], 
				':message'    => $data['contact_message'], 
				':contactdate' => time(), 
			))
			->execute();

				$mailheaders = "";
				$mailheaders .= "From: casuvi <no-reply@".$_SERVER['SERVER_NAME'].">\r\n";
				$mailheaders .= 'MIME-Version: 1.0' . "\r\n";
				$mailheaders .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

			$area = Model::factory('Contactarea')->fetch(array('id'=>$data['area']));

				$msg = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Silanes</title>
<base href="http://'.$_SERVER['SERVER_NAME'].'" />
<style type="text/css">
body { padding: 0; margin: 0; font-family: Arial; font-size: 14px; color: #000; }
html { padding: 0; margin: 0; }
p { padding-right: 55px; padding-left: 65px; padding-top: 8px; }
</style>
</head>
<body>
<div style="width: 800px; overflow: hidden;">
<div style="height: 415px; width: 100%; float: left;">
<strong>Contacto casuvi recibido:</strong>
<p>
<strong>Nombre:</strong> '.$data['contact_name'].'<br>
<strong>Email:</strong> '.$data['contact_email'].'<br>
<strong>Phone:</strong> '.$data['contact_phone'].'<br>
<strong>Mensaje:</strong> '.nl2br($data['contact_message']).'
</p>
</div>
</div>
</body>
</html>
';

//			$msg = utf8_decode($msg);
			
			
				$subject= "=?utf-8?b?".base64_encode("Contacto casuvi")."?=";

				mail($area['email'], $subject, $msg, $mailheaders);
				/*if(Arr::get($data, 'sendcopy', 0)){
					mail($data['email'], $subject, $msg, $mailheaders);
				}*/
	
		return $id;
	}
	

	public function update($data, $files)
	{
		DB::query(Database::UPDATE, "
				UPDATE contact
				SET
					title = :title, 
					email = :email, 
					status = :status
				WHERE id = :id
			")
			->parameters(array(
				':title'    => $data['title'], 
				':email'    => $data['email'], 
				':status'   => $data['status'],
				':id'       => $data['id'],
			))
			->execute();
			
		return $data['id'];
	}


	public function validate($data)
	{
		$data = (array) $data;
		
		$data = Validation::factory($data)
			->rule('title', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(0, 1)));

		return $data;
	}

	private function _position()
	{
		return DB::query(Database::SELECT, "
				SELECT (position + 1) AS position 
				FROM contact 
				WHERE is_deleted = 0 
				ORDER BY position DESC
				LIMIT 0,1
			")
			->execute()
			->get('position', 1);
	}
	

	public function sort($serialized)
	{
		
		$query = DB::query(Database::UPDATE, "UPDATE contact SET position = :position WHERE id = :id")
			->bind(':position', $position)
			->bind(':id', $id);
		
		$i = 0;
		foreach ($serialized['item'] as $id => $parent_id)
		{
			$position = $i;
			$query->execute();
			$i++;
		}
	}

}