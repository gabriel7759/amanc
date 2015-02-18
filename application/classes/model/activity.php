<?php defined('SYSPATH') or die('No direct script access.');

class Model_Activity extends Model {
	public function add_popular($id_activity){
		if($id_activity){
			$exist = DB::query(Database::SELECT, "
							SELECT id
							FROM activity_popular
							WHERE id_activity = :id_activity")
						->parameters(array(':id_activity'=>$id_activity))->execute()->current();
			if($exist){
				DB::query(Database::UPDATE, "UPDATE activity_popular SET total = total+1 WHERE id_activity = :id_activity")->parameters(array(':id_activity'     => $id_activity))->execute();
			}else{
				list($id) = DB::query(Database::INSERT, "
					INSERT INTO activity_popular (id_activity, total) 
					VALUES (:id_activity, 1)")
				->parameters(array(
					':id_activity'     => $id_activity
				))
				->execute();
			}
		}
		return false;
	}
	public function get_popular(){
		$data = DB::query(Database::SELECT, "
				SELECT SQL_CALC_FOUND_ROWS 
					t2.id, 
					t2.title,
					t2.title as name, 
					t2.summary,
					IF(LENGTH(t2.thumbnail)>0, CONCAT('/assets/files/activity/',thumbnail), '') AS src_picture,  
					t3.state as state
				FROM 
					activity_popular t1
				INNER JOIN activity t2 ON t1.id_activity = t2.id
				LEFT JOIN state t3 ON t2.state_id = t3.id
				LEFT JOIN 
					sys_lookup ON sys_lookup.code = t2.status AND sys_lookup.type = 'status'
				WHERE 
					t2.is_deleted = 0 AND t2.status = 1
				ORDER BY t1.total DESC LIMIT 4
			")
			->execute();
		return $data;
	}
	public function fetch_all($params){
		$sql   = "";
		$limit = "";
		$parameters = array();
		if ( ! in_array($params['order_by'], array('t1.title', 't1.id')) )
			throw new Kohana_Exception('"'.$params['order_by']. '" is an invalid column for sorting results.');
			
		if ( ! in_array($params['sort'], array('ASC', 'DESC', 'RAND()')) )
			throw new Kohana_Exception('"sort" param must be either ASC, DESC or RAND(). "'.$params['sort'].'" given.');
		
		if (ctype_digit( (string) $params['status']))
		{
			$sql .= " AND t1.status = :status";
			$parameters[':status'] = $params['status'];
		}
		if (ctype_digit( (string) $params['state_id']))
		{
			$sql .= " AND t1.state_id = :state_id";
			$parameters[':state_id'] = $params['state_id'];
		}
		if (ctype_digit( (string) $params['tag_id']))
		{
			$sql .= " AND t3.tag_id = :tag_id";
			$parameters[':tag_id'] = $params['tag_id'];
			$extra .= "LEFT JOIN tag_content t3 ON t1.id = t3.content_id AND t3.module_id = 8";
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
					t1.state_id, 
					t1.title,
					t1.title as name, 
					t1.summary,
					t1.content,
					t1.thumbnail,
					t1.url,
					t1.newwindow,
					IF(LENGTH(t1.thumbnail)>0, CONCAT('/assets/files/activity/',thumbnail), '') AS src_picture,  
					t2.state as state,
					sys_lookup.name AS status, 
					IF(t1.status=0, 'inactive', '') AS mode
				FROM 
					activity t1
				LEFT JOIN state t2 ON t1.state_id = t2.id
				LEFT JOIN 
					sys_lookup ON sys_lookup.code = t1.status AND sys_lookup.type = 'status'
				".$extra."
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
			$sql .= " AND t1.id = :id";
			$parameters[':id'] = $params['id'];
			$id = $params['id'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT 
					t1.id, 
					t1.state_id, 
					t1.title, 
					t1.title as name, 
					t1.summary,
					t1.content,
					t1.thumbnail,
					t1.url,
					t1.newwindow,
					IF(LENGTH(t1.thumbnail)>0, CONCAT('/assets/files/activity/',t1.thumbnail), '') AS src_picture,  
					t1.log_id,
					IF(t1.status=0, 'inactive', '') AS mode,
					t2.state as state
				FROM 
					activity t1
				LEFT JOIN state t2 ON t1.state_id = t2.id
				WHERE 
					t1.is_deleted = 0 
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
		
		$data['tags_selected'] = $this->_fetch_tags_selected($id);
		
		return $data;
	}
	
	public function _fetch_tags_selected($id){
		$tags_selected = DB::query(Database::SELECT, "
							SELECT id, module_id, content_id, tag_id
							FROM tag_content t1
							WHERE content_id = ".$id." AND module_id = 8")
						->execute()->as_array();
		return $tags_selected;
	}


	public function insert($data, $files)
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO activity (title, state_id, status, summary, content, url, newwindow, is_deleted, log_id) 
				VALUES (:title, :state_id, :status, :summary, :content, :url, :newwindow, 0, 0)
			")
			->parameters(array(
				':title'     => $data['title'], 
				':state_id'  => $data['state_id'], 
				':status'    => $data['status'],
				':summary'   => $data['summary'],
				':content'   => $data['content'],
				':url'       => $data['url'],
				':newwindow' => $data['newwindow'],
			))
			->execute();
			
			$this->_upload_media($id, $files, $data);
			
			if($data['tag_id']){
				foreach($data['tag_id'] as $p){
					DB::query(Database::INSERT, "
						INSERT INTO tag_content (content_id, tag_id, module_id)
						VALUES (:activity_id, :tag_id, 8)
					")
					->parameters(array(
						':activity_id'    => $id,
						':tag_id'   => $p,	
					))->execute();				
				}
			}
		return $id;
	}
	
	public function update($data, $files)
	{
		DB::query(Database::UPDATE, "
				UPDATE activity
				SET
					title = :title,
					state_id = :state_id,
					summary = :summary,
					content = :content,
					url = :url,
					newwindow = :newwindow,
					status = :status
				WHERE id = :id
			")
			->parameters(array(
				':title'     => $data['title'], 
				':state_id'  => $data['state_id'], 
				':summary'   => $data['summary'],
				':content'   => $data['content'],
				':url'       => $data['url'],
				':newwindow' => $data['newwindow'],
				':status'    => $data['status'],
				':id'        => $data['id'],
			))
			->execute();
			
		$this->_upload_media($data['id'], $files, $data);
			
		DB::query(Database::INSERT, "DELETE FROM tag_content WHERE content_id = :activity_id AND module_id = 8")
				->parameters(array(':activity_id' => $data['id']))->execute();
		
		foreach($data['tag_id'] as $p) {
				DB::query(Database::INSERT, "
					INSERT INTO tag_content (content_id, tag_id, module_id)
					VALUES (:activity_id, :tag_id, 8)
				")
				->parameters(array(
					':activity_id'   => $data['id'],
					':tag_id'       => $p,	
					':module_id'    => $modulo,	
				))->execute();				
		}	
		return $data['id'];
	}
	
	protected function _upload_media($id, $files, $data)
	{
		$media = array(
			'thumbnail' => 'assets/files/activity',
		);
		
		foreach ($media as $asset => $path)
		{	
		
			$file = Upload::save($_FILES[$asset], NULL, DOCROOT.$path);
			if ($file !== FALSE)
			{
				$file = basename($file);
				DB::query(Database::UPDATE, "UPDATE activity SET $asset = :asset WHERE id = :id")
					->parameters(array(
						':asset' => $file, 
						':id'    => $id, 
					))
					->execute();
			}
			
			if ($data[$asset.'_del'])
			{
				DB::query(Database::UPDATE, "UPDATE activity SET $asset = '' WHERE id = :id")->parameters(array(':id' => $id))->execute();
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
		$query = DB::query(Database::UPDATE, "UPDATE activity SET position = :position WHERE id = :id")
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