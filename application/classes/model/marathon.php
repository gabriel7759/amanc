<?php defined('SYSPATH') or die('No direct script access.');

class Model_Marathon extends Model {
	
	public function fetch_all($params)
	{
		$sql   = "";
		$limit = "";
		$parameters = array();
		
		if ( ! in_array($params['order_by'], array('t1.date_marathon')) )
			throw new Kohana_Exception('"'.$params['order_by']. '" is an invalid column for sorting results.');
			
		if ( ! in_array($params['sort'], array('ASC', 'DESC', 'RAND()')) )
			throw new Kohana_Exception('"sort" param must be either ASC, DESC or RAND(). "'.$params['sort'].'" given.');
		
		if (ctype_digit( (string) $params['status']))
		{
			$sql .= " AND t1.status = :status";
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
					t1.id,
					t1.title,
					t1.summary,
					t1.content,
					t1.picture,
					t1.date_marathon,
					IF(LENGTH(t1.thumbnail)>0, CONCAT('/assets/files/marathon/',t1.thumbnail), '') AS src_thumbnail,  
					IF(LENGTH(t1.picture)>0, CONCAT('/assets/files/marathon/',t1.picture), '') AS src_picture,  
					sys_lookup.name AS status,
					IF(t1.status=0, 'inactive', '') AS mode
				FROM 
					marathon t1
				LEFT JOIN 
					sys_lookup ON sys_lookup.code = t1.status AND sys_lookup.type = 'status'
				WHERE 
					t1.is_deleted = 0 
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
			$sql .= " AND id = :id";
			$parameters[':id'] = $params['id'];
			$id = $params['id'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT 
					*,
					IF(LENGTH(thumbnail)>0, CONCAT('/assets/files/news/',thumbnail), '') AS src_picture, 
					log_id,
					IF(status=0, 'inactive', '') AS mode
				FROM 
					marathon
				WHERE 
					is_deleted = 0 
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

	public function insert($data)
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO news (title, summary, content, url, newwindow, newsdate, status, is_deleted, log_id) 
				VALUES (:title, :summary, :content, :url, :newwindow, :newsdate, :status, 0, 0)
			")
			->parameters(array(
				':title'     => $data['title'], 
				':content'   => $data['content'], 
				':summary'   => $data['summary'],
				':url'       => $data['url'],
				':newwindow' => $data['newwindow'],
				':newsdate'  => strtotime($data['newsdate']), 
				':status'    => $data['status'],
			))
			->execute();
			
			$this->_upload_media($data['id'], $files, $data);
		return $id;
	}
	
	public function update($data)
	{
		DB::query(Database::UPDATE, "
				UPDATE marathon
				SET
					title = :title,
					summary = :summary,
					content = :content,
					thumbnail = :thumbnail,
					picture = :picture,
					date_marathon = :date_marathon,
					google_map = :google_map,
					status = :status
				WHERE id = :id
			")
			->parameters(array(
				':title'      => $data['title'], 
				':content'    => $data['content'], 
				':summary'    => $data['summary'],
				':thumbnail'  => $data['thumbnail'],
				':picture' 		  => $data['picture'],
				':date_marathon'  => strtotime($data['date_marathon']),
				':google_map'   => $data['google_map'],
				':status'     => $data['status'],
				':id'         => $data['id'],
			))
			->execute();
			
		$this->_upload_media($data['id'], $files, $data);	
		return $data['id'];
	}
	
	protected function _upload_media($id, $files, $data){
		$media = array(
			'thumbnail' => 'assets/files/marathon',
			'picture' => 'assets/files/marathon',
		);
		
		foreach ($media as $asset => $path){	
			$file = Upload::save($_FILES[$asset], NULL, DOCROOT.$path);
			if ($file !== FALSE)
			{
				$file = basename($file);
				DB::query(Database::UPDATE, "UPDATE marathon SET $asset = :asset WHERE id = :id")
					->parameters(array(
						':asset' => $file, 
						':id'    => $id, 
					))
					->execute();
			}
			
			if ($data[$asset.'_del'])
			{
				DB::query(Database::UPDATE, "UPDATE marathon SET $asset = '' WHERE id = :id")->parameters(array(':id' => $id))->execute();
			}
		}
		
		return TRUE;
	}	

	public function validate($data)
	{
		$data = (array) $data;
		
		$data = Validation::factory($data)
			->rule('title', 'not_empty')
			->rule('date_marathon', 'not_empty')
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
		$query = DB::query(Database::UPDATE, "UPDATE news SET position = :position WHERE id = :id")
			->bind(':position', $position)
			->bind(':id', $id);
		
		$i = count($serialized);
		foreach ($serialized['item'] as $id => $parent_id)
		{
			$position = $i;
			$query->execute();
			$i--;
		}
	}

}