<?php defined('SYSPATH') or die('No direct script access.');

class Model_News extends Model {
	
	public function fetch_all($params)
	{
		$sql   = "";
		$limit = "";
		$parameters = array();
		
		if ( ! in_array($params['order_by'], array('news.newsdate')) )
			throw new Kohana_Exception('"'.$params['order_by']. '" is an invalid column for sorting results.');
			
		if ( ! in_array($params['sort'], array('ASC', 'DESC', 'RAND()')) )
			throw new Kohana_Exception('"sort" param must be either ASC, DESC or RAND(). "'.$params['sort'].'" given.');
		
		if (ctype_digit( (string) $params['status']))
		{
			$sql .= " AND news.status = :status";
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
					news.id, 
					news.slug,
					news.title, 
					news.title as name, 
					news.newsdate, 
					news.summary,
					news.content,
					news.thumbnail,
					news.url,
					news.newwindow,
					IF(news.url='', CONCAT('/noticias/', news.id, '/', news.slug) , news.url) as href, 
					IF(news.newwindow=1, '_blank', '_self') as target,					
					IF(LENGTH(news.thumbnail)>0, CONCAT('/assets/files/news/',thumbnail), '') AS src_picture,  
					sys_lookup.name AS status,
					IF(news.status=0, 'inactive', '') AS mode
				FROM 
					news
				LEFT JOIN 
					sys_lookup ON sys_lookup.code = news.status AND sys_lookup.type = 'status'
				WHERE 
					news.is_deleted = 0 
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
					slug,
					title, 
					title as name, 
					newsdate, 
					summary,
					content,
					thumbnail,
					url,
					newwindow,
					IF(LENGTH(thumbnail)>0, CONCAT('/assets/files/news/',thumbnail), '') AS src_picture, 
					log_id,
					IF(status=0, 'inactive', '') AS mode
				FROM 
					news
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
							WHERE content_id = ".$id." AND module_id = 6")
						->execute()->as_array();
		return $tags_selected;
	}	

	public function insert($data)
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO news (slug, title, summary, content, url, newwindow, newsdate, status, is_deleted, log_id) 
				VALUES (:slug, :title, :summary, :content, :url, :newwindow, :newsdate, :status, 0, 0)
			")
			->parameters(array(
				':slug'      => $data['slug'],
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
			
			if($data['tag_id']){
				foreach($data['tag_id'] as $p){
					DB::query(Database::INSERT, "
						INSERT INTO tag_content (content_id, tag_id, module_id)
						VALUES (:content_id, :tag_id, 6)
					")
					->parameters(array(
						':content_id'      => $id,
						':tag_id'          => $p,	
						':module_id'       => '6',	
					))->execute();				
				}
			}
		return $id;
	}
	
	public function update($data)
	{
		DB::query(Database::UPDATE, "
				UPDATE news
				SET
					slug = :slug,
					title = :title,
					summary = :summary,
					content = :content,
					thumbnail = :thumbnail,
					url = :url,
					newwindow = :newwindow,
					newsdate = :newsdate, 
					status = :status
				WHERE id = :id
			")
			->parameters(array(
				':slug'       => $data['slug'],
				':title'      => $data['title'], 
				':content'    => $data['content'], 
				':summary'    => $data['summary'],
				':thumbnail'  => $data['thumbnail'],
				':url' 		  => $data['url'],
				':newwindow'  => $data['newwindow'],
				':newsdate'   => strtotime($data['newsdate']),
				':status'     => $data['status'],
				':id'         => $data['id'],
			))
			->execute();
			
		$this->_upload_media($data['id'], $files, $data);
			
		DB::query(Database::INSERT, "DELETE FROM tag_content WHERE content_id = :content_id AND module_id = 6")
				->parameters(array(':content_id' => $data['id']))->execute();
				
		foreach($data['tag_id'] as $p){
				DB::query(Database::INSERT, "
					INSERT INTO tag_content (content_id, tag_id, module_id)
					VALUES (:content_id, :tag_id, 6)
				")
				->parameters(array(
					':content_id'   => $data['id'],
					':tag_id'       => $p,	
					':module_id'    => '6',	
				))->execute();				
		}	
		return $data['id'];
	}
	
	protected function _upload_media($id, $files, $data)
	{
		$media = array(
			'thumbnail' => 'assets/files/news',
		);
		
		foreach ($media as $asset => $path)
		{	
		
			$file = Upload::save($_FILES[$asset], NULL, DOCROOT.$path);
			if ($file !== FALSE)
			{
				$file = basename($file);
				DB::query(Database::UPDATE, "UPDATE news SET $asset = :asset WHERE id = :id")
					->parameters(array(
						':asset' => $file, 
						':id'    => $id, 
					))
					->execute();
			}
			
			if ($data[$asset.'_del'])
			{
				DB::query(Database::UPDATE, "UPDATE news SET $asset = '' WHERE id = :id")->parameters(array(':id' => $id))->execute();
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