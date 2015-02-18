<?php defined('SYSPATH') or die('No direct script access.');

class Model_Slide extends Model {
	
	public function fetch_all($params)
	{
		$sql   = "";
		$limit = "";
		$parameters = array();
		
		if ( ! in_array($params['order_by'], array('slide.position')) )
			throw new Kohana_Exception('"'.$params['order_by']. '" is an invalid column for sorting results.');
			
		if ( ! in_array($params['sort'], array('ASC', 'DESC', 'RAND()')) )
			throw new Kohana_Exception('"sort" param must be either ASC, DESC or RAND(). "'.$params['sort'].'" given.');
		
		if (ctype_digit( (string) $params['status']))
		{
			$sql .= " AND slide.status = :status";
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
					slide.id, 
					slide.title, 
					slide.title as name, 
					sys_lookup.name AS status, 
					IF(slide.status=0, 'inactive', '') AS mode
				FROM 
					slide
				LEFT JOIN 
					sys_lookup ON sys_lookup.code = slide.status AND sys_lookup.type = 'status'
				WHERE 
					slide.is_deleted = 0 
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
			$sql .= " AND slide.id = :id";
			$parameters[':id'] = $params['id'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT 
					slide.id, 
					slide.title, 
					slide.title as name, 
					slide.summary, 
					slide.url, 
					slide.picture,
					slide.newwindow, 
					slide.log_id,
					IF(slide.status=0, 'inactive', '') AS mode
				FROM 
					slide
				WHERE 
					slide.is_deleted = 0 
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
					slide.id, 
					slide.title, 
					slide.title as name,
					slide.summary, 
					slide.url, 
					slide.picture, CONCAT('assets/files/slide/', slide.picture) as src_picture,
					slide.newwindow
				FROM 
					slide
				WHERE 
					slide.is_deleted = 0 
					AND slide.status = 1
				ORDER BY
					slide.position ASC
			")
			->execute()
			->as_array();
		
	}


	public function insert($data, $files)
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO slide (title, summary, url, picture, newwindow, position, status, is_deleted, log_id) 
				VALUES (:title, :summary, :url, '', :newwindow, :position, :status, 0, 0)
			")
			->parameters(array(
				':title'    => $data['title'], 
				':summary'    => $data['summary'], 
				':url'    => $data['url'], 
				':newwindow'    => $data['newwindow'], 
				':position'  => $this->_position(), 
				':status'   => $data['status'],
			))
			->execute();
		
		$this->_upload_media($id, $files, $data);
		
		return $id;
	}
	
	public function update($data, $files)
	{
		DB::query(Database::UPDATE, "
				UPDATE slide
				SET
					title = :title, 
					summary = :summary,
					url = :url, 
					newwindow = :newwindow, 
					status = :status
				WHERE id = :id
			")
			->parameters(array(
				':title'     => $data['title'],
				':summary'   => $data['summary'],
				':url'       => $data['url'], 
				':newwindow' => $data['newwindow'], 
				':status'    => $data['status'],
				':id'        => $data['id'],
			))
			->execute();
			
		$this->_upload_media($data['id'], $files, $data);

		return $data['id'];
	}

	protected function _upload_media($id, $files, $data)
	{
		$media = array(
			'picture' => 'assets/files/slide',
		);
		
		foreach ($media as $asset => $path)
		{	
		
			$file = Upload::save($_FILES[$asset], NULL, DOCROOT.$path);
			if ($file !== FALSE)
			{
				$file = basename($file);
				DB::query(Database::UPDATE, "UPDATE slide SET $asset = :asset WHERE id = :id")
					->parameters(array(
						':asset' => $file, 
						':id'    => $id, 
					))
					->execute();
			}
			
			if ($data[$asset.'_del'])
			{
				DB::query(Database::UPDATE, "UPDATE slide SET $asset = '' WHERE id = :id")->parameters(array(':id' => $id))->execute();
			}
		}
		
		return TRUE;
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
				FROM slide 
				WHERE is_deleted = 0 
				ORDER BY position DESC
				LIMIT 0,1
			")
			->execute()
			->get('position', 1);
	}
	

	public function sort($serialized)
	{
		
		$query = DB::query(Database::UPDATE, "UPDATE slide SET position = :position WHERE id = :id")
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