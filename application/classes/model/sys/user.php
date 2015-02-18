<?php defined('SYSPATH') or die('No direct script access.');

class Model_Sys_User extends Model {
	
	const SYSTEM = 1;
	
	public function fetch_by_email($email)
	{
		$user = DB::query(Database::SELECT, "
				SELECT 
					sys_user.id, 
					sys_user.role_id, 
					sys_role.name AS role, 
					sys_user.first_name, 
					sys_user.last_name, 
					sys_role.system, 
					CONCAT(sys_user.first_name, ' ', sys_user.last_name) AS name, 
					sys_user.email, 
					sys_user.password
				FROM 
					sys_user 
				LEFT JOIN 
					sys_role ON sys_role.id = sys_user.role_id
				WHERE 
					sys_user.email = :email AND 
					sys_user.status = 1 AND 
					sys_user.is_deleted = 0 AND 
					sys_role.status = 1 AND 
					sys_role.is_deleted = 0
			")
			->parameters(array(
				':email' => $email,
			))
			->execute()
			->current();
		
		$access_control = DB::query(Database::SELECT, "
				SELECT 
					module_id, 
					CONCAT(module_id, '.', action) AS permission 
				FROM 
					sys_access_control 
				WHERE 
					role_id = :role_id
			")
			->parameters(array(
				':role_id' => $user['role_id'], 
			))
			->execute();
		
		$user['modules']     = array_unique($access_control->as_array(NULL, 'module_id'));
		$user['permissions'] = $access_control->as_array(NULL, 'permission');
		
		return $user;
	}
	
	public function fetch_all($params)
	{
		$sql   = "";
		$limit = "";
		$parameters = array();
		
		if ( ! in_array($params['order_by'], array('sys_user.first_name', 'sys_user.last_name', 'sys_role.role', 'sys_user.last_login', 'sys_user.date_created', 'status')) )
			throw new Kohana_Exception('"'.$params['order_by']. '" is an invalid column for sorting results.');
			
		if ( ! in_array($params['sort'], array('ASC', 'DESC', 'RAND()')) )
			throw new Kohana_Exception('"sort" param must be either ASC, DESC or RAND(). "'.$params['sort'].'" given.');
		
		if (ctype_digit( (string) $params['status']))
		{
			$sql .= " AND sys_user.status = :status";
			$parameters[':status'] = $params['status'];
		}
		if (ctype_digit( (string) $params['role_id']))
		{
			$sql .= " AND sys_user.role_id = :role_id";
			$parameters[':role_id'] = $params['role_id'];
		}
		if ( ! empty($params['text']))
		{
			$sql .= " AND (sys_user.first_name LIKE :text OR sys_user.last_name LIKE :text OR sys_user.email LIKE :text)";
			$parameters[':text'] = '%'.$params['text'].'%';
		}
		if (ctype_digit( (string) $params['system']))
		{
			$sql .= " AND sys_role.system = :system";
			$parameters[':system'] = $params['system'];
		}
		if (ctype_digit( (string) $params['limit']) AND ctype_digit( (string) $params['offset']))
		{
			$limit = "LIMIT :offset, :limit";
			$parameters[':offset'] = $params['offset'];
			$parameters[':limit']  = $params['limit'];
		}
		
		return DB::query(Database::SELECT, "
				SELECT SQL_CALC_FOUND_ROWS 
					sys_user.id, 
					sys_user.role_id, 
					sys_role.name AS role, 
					sys_user.first_name, 
					sys_user.last_name, 
					CONCAT(sys_user.first_name, ' ', sys_user.last_name) AS name, 
					sys_user.email, 
					sys_user.password, 
					sys_user.last_login, 
					sys_lookup.name AS status, 
					IF(sys_user.status=0, 'inactive', '') AS mode, 
					sys_user.date_created  
				FROM 
					sys_user 
				LEFT JOIN 
					sys_role ON sys_role.id = sys_user.role_id
				LEFT JOIN 
					sys_lookup ON sys_lookup.code = sys_user.status AND sys_lookup.type = 'status'
				WHERE 
					sys_user.is_deleted = 0 AND 
					sys_role.is_deleted = 0 
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
			$sql .= " AND sys_user.id = :id";
			$parameters[':id'] = $params['id'];
		}
		if (ctype_digit( (string) $params['system']))
		{
			$sql .= " AND sys_role.system = :system";
			$parameters[':system'] = $params['system'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT 
					sys_user.id, 
					sys_user.role_id, 
					sys_user.first_name, 
					sys_user.last_name, 
					CONCAT(sys_user.first_name, ' ', sys_user.last_name) AS name, 
					sys_user.email, 
					sys_user.password, 
					sys_user.last_login, 
					sys_user.logins, 
					sys_user.status, 
					sys_user.log_id 
				FROM 
					sys_user
				LEFT JOIN
					sys_role ON sys_role.id = sys_user.role_id
				WHERE 
					sys_user.is_deleted = 0 
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
		}
		
		return $data;
	}
	
	public function insert($data)
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO sys_user (role_id, first_name, last_name, email, password, last_login, last_modified, date_created, status)
				VALUES (:role_id, :first_name, :last_name, :email, :password, :last_login, :last_modified, :date_created, :status)
			")
			->parameters(array(
				':role_id'       => $data['role_id'],
				':first_name'    => $data['first_name'],
				':last_name'     => $data['last_name'],
				':email'         => $data['email'],
				':password'      => $data['password'],
				':last_login'    => NULL,
				':last_modified' => time(),
				':date_created'  => time(),
				':status'        => $data['status'],
			))
			->execute();
		
		return $id;
	}
	
	public function update($data)
	{
		DB::query(Database::UPDATE, "
				UPDATE sys_user 
				SET role_id = :role_id, first_name = :first_name, last_name = :last_name, email = :email, last_modified = :last_modified, status = :status
				WHERE id = :id
			")
			->parameters(array(
				':role_id'       => $data['role_id'],
				':first_name'    => $data['first_name'],
				':last_name'     => $data['last_name'],
				':email'         => $data['email'],
				':last_modified' => time(),
				':status'        => $data['status'],
				':id'            => $data['id'],
			))
			->execute();
		
		if ($data['area'])
		{
			$this->update_areas($data['area'], $data['id']);
		}
		
		return $data['id'];
	}
	
	public function validate($data)
	{
		$data = (array) $data;
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('first_name', 'not_empty')
			->rule('last_name', 'not_empty')
			->rule('email', 'email')
			->rule('email', 'Model_Sys_User::unique_email', array($data['id'], $data['email']))
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(0, 1)));
		
		if ( ! $data['id'])
		{
			$data->rule('password', 'not_empty');
			$data->rule('password', 'min_length', array(':value', '8'));
		}

		return $data;
	}
	
	public static function unique_email($user_id, $email)
	{
		$params = array(
			':email' => $email,
		);
		
		if ($user_id)
		{
			$user = Model::factory('Sys_User')->fetch(array(
				'id' => $user_id
			));
			$sql  = " AND email <> :current_email";
			$params[':current_email'] = $user['email'];
		}
		
		return ! DB::query(Database::SELECT, "SELECT COUNT(id) AS total FROM sys_user WHERE email = :email AND is_deleted = 0".$sql)
			->parameters($params)
			->execute()
			->get('total', 0);
	}
	
	public function complete_login($user)
	{
		DB::query(Database::UPDATE, "UPDATE sys_user SET last_login = :last_login, logins = logins+1 WHERE id = :id")
			->parameters(array(
				':id' => $user['id'],
				':last_login' =>  time(),
			))
			->execute();
		
		return TRUE;
	}
	
	public function forgot($username)
	{
		$user = DB::select('id')
			->from('sys_user')
			->where('email', '=', $username)
			->where('status', '=', 1)
			->where('is_deleted', '=', 0)
			->execute()
			->current();
			
		if( ! $user)
			return FALSE;

		$newpassword_text = Text::random('alnum', 8);


		DB::update('sys_user')
			->set(array('password' => Auth::instance()->hash_password($newpassword_text)))
			->where('id', '=', $user['id'])
			->execute();
		
		$data = array("newpassword"=>$newpassword);
		
		// Send mail
		


		$mailTo = $username;

		$mailFrom = "Webmaster <webmaster@copyleftsolutions.no>";
		$subject = $site->title." (".__('Forgot your password?').")";
		$message = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<base href="'.$site->url.'">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>'.$subject.'</title>
		<style type="text/css">
		body { font: normal 11px Arial, Helvetica, Verdana; color: #000; }
		</style>
		</head>
		<body>
		<div>
		'.__('We have received a request to generate a new password and here it is').':<br />
		<br /><strong>'.$newpassword_text.'</strong><br /><br />
		
		</div>
		</body>
		</html>
		';
		$mailheaders = "From: " . $mailFrom . " \n";
		$mailheaders .= 'Content-type: text/html; charset=utf8' . "\r\n";
		mail($mailTo, $subject, $message, $mailheaders);
		
//		$this->_log_transaction($this->_module_id, $user['id'], $user['name'], $data, 4);

		return TRUE;
	}
	
}