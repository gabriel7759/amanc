<?php defined('SYSPATH') or die('No direct script access.');

class Model_Contactarea extends Model {
	
	public function fetch_all($params)
	{
		$sql   = "";
		$limit = "";
		$parameters = array();
		
		if ( ! in_array($params['order_by'], array('contactarea.position')) )
			throw new Kohana_Exception('"'.$params['order_by']. '" is an invalid column for sorting results.');
			
		if ( ! in_array($params['sort'], array('ASC', 'DESC', 'RAND()')) )
			throw new Kohana_Exception('"sort" param must be either ASC, DESC or RAND(). "'.$params['sort'].'" given.');
		
		if (ctype_digit( (string) $params['status']))
		{
			$sql .= " AND contactarea.status = :status";
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
					contactarea.id, 
					contactarea.title, 
					contactarea.title as name, 
					sys_lookup.name AS status, 
					IF(contactarea.status=0, 'inactive', '') AS mode
				FROM 
					contactarea
				LEFT JOIN 
					sys_lookup ON sys_lookup.code = contactarea.status AND sys_lookup.type = 'status'
				WHERE 
					contactarea.is_deleted = 0 
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
			$sql .= " AND contactarea.id = :id";
			$parameters[':id'] = $params['id'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT 
					contactarea.id, 
					contactarea.title, 
					contactarea.title as name, 
					contactarea.email, 
					contactarea.log_id,
					IF(contactarea.status=0, 'inactive', '') AS mode
				FROM 
					contactarea
				WHERE 
					contactarea.is_deleted = 0 
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
					contactarea.id, 
					contactarea.title, 
					contactarea.title as name, 
					contactarea.email
				FROM 
					contactarea
				WHERE 
					contactarea.is_deleted = 0 
					AND contactarea.status = 1
				ORDER BY
					contactarea.position ASC
			")
			->execute()
			->as_array();
		
	}


	public function insert($data, $files)
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO contactarea (title, email, position, status, is_deleted, log_id) 
				VALUES (:title, :email, :position, :status, 0, 0)
			")
			->parameters(array(
				':title'    => $data['title'], 
				':email'    => $data['email'], 
				':position'  => $this->_position(), 
				':status'   => $data['status'],
			))
			->execute();
		
		return $id;
	}
	
	public function update($data, $files)
	{
		DB::query(Database::UPDATE, "
				UPDATE contactarea
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
				FROM contactarea 
				WHERE is_deleted = 0 
				ORDER BY position DESC
				LIMIT 0,1
			")
			->execute()
			->get('position', 1);
	}
	

	public function sort($serialized)
	{
		
		$query = DB::query(Database::UPDATE, "UPDATE contactarea SET position = :position WHERE id = :id")
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