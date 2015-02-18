<?php defined('SYSPATH') or die('No direct script access.');

class Model_Project extends Model {
	
	public function fetch_all($params)
	{
		$sql   = "";
		$limit = "";
		$parameters = array();

		if (ctype_digit( (string) $params['status']))
		{
			$sql .= " AND project.status = :status";
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
					project.id, 
					project.title,
					project.summary,
					project.content,
					project.thumbnail, CONCAT('/assets/files/project/', project.thumbnail, '') AS src_picture, 
					project.url,
					project.newwindow,
					project.title as name, 
					sys_lookup.name AS status, 
					IF(project.status=0, 'inactive', '') AS mode
				FROM 
					project
				LEFT JOIN 
					sys_lookup ON sys_lookup.code = project.status AND sys_lookup.type = 'status'
				WHERE 
					project.is_deleted = 0 
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
					id,
					title, 
					title as name, 
					summary,
					content,
					thumbnail, IF(LENGTH(thumbnail)>0, CONCAT('/assets/files/project/',thumbnail), '') AS src_picture, 
					url,
					newwindow,
					log_id,
					IF(status=0, 'inactive', '') AS mode
				FROM 
					project
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
		
		$data['tags_selected'] = $this->_fetch_tags_selected($id);
		
		return $data;
	}
	
	
	public function _fetch_tags_selected($id){
		$tags_selected = DB::query(Database::SELECT, "
							SELECT id, module_id, content_id, tag_id
							FROM tag_content t1
							WHERE content_id = ".$id." AND module_id = 15")
						->execute()->as_array();
		return $tags_selected;
	}


	public function insert($data)
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO project (title, summary, content, url, newwindow, status, is_deleted, log_id) 
				VALUES (:title, :summary, :content, :url, :newwindow, :status, 0, 0)
			")
			->parameters(array(
				':title'     => $data['title'], 
				':content'   => $data['content'], 
				':summary'   => $data['summary'],
				':url'       => $data['url'],
				':newwindow' => $data['newwindow'],
				':status'    => $data['status'],
			))
			->execute();
			
			$this->_upload_media($id, $files, $data);
			
			if($data['tag_id']){
				foreach($data['tag_id'] as $p){
					DB::query(Database::INSERT, "
						INSERT INTO tag_content (content_id, tag_id, module_id)
						VALUES (:activity_id, :tag_id, 15)
					")
					->parameters(array(
						':activity_id'    => $id,
						':tag_id'   => $p,	
					))->execute();				
				}
			}
			
			
		return $id;
	}
	
	public function update($data)
	{
		DB::query(Database::UPDATE, "
				UPDATE project
				SET
					title = :title,
					summary = :summary,
					content = :content, 
					thumbnail = :thumbnail,
					url = :url,
					newwindow = :newwindow,
					status = :status
				WHERE id = :id
			")
			->parameters(array(
				':title'     => $data['title'], 
				':content'   => $data['content'], 
				':summary'   => $data['summary'],
				':thumbnail' => $data['thumbnail'],
				':url'       => $data['url'],
				':newwindow' => $data['newwindow'],
				':status'    => $data['status'],
				':id'        => $data['id'],
			))
			->execute();
			
		$this->_upload_media($data['id'], $files, $data);
		
		DB::query(Database::INSERT, "DELETE FROM tag_content WHERE content_id = :activity_id AND module_id = 15")
				->parameters(array(':activity_id' => $data['id']))->execute();
		
		foreach($data['tag_id'] as $p) {
				DB::query(Database::INSERT, "
					INSERT INTO tag_content (content_id, tag_id, module_id)
					VALUES (:activity_id, :tag_id, 15)
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
			'thumbnail' => 'assets/files/project',
		);
		
		foreach ($media as $asset => $path)
		{	
		
			$file = Upload::save($_FILES[$asset], NULL, DOCROOT.$path);
			if ($file !== FALSE)
			{
				$file = basename($file);
				DB::query(Database::UPDATE, "UPDATE project SET $asset = :asset WHERE id = :id")
					->parameters(array(
						':asset' => $file, 
						':id'    => $id, 
					))
					->execute();
			}
			
			if ($data[$asset.'_del'])
			{
				DB::query(Database::UPDATE, "UPDATE project SET $asset = '' WHERE id = :id")->parameters(array(':id' => $id))->execute();
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
	
	public function sort($serialized)
	{
		$query = DB::query(Database::UPDATE, "UPDATE project SET position = :position WHERE id = :id")
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