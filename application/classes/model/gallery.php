<?php defined('SYSPATH') or die('No direct script access.');

class Model_Gallery extends Model {
	
	public function fetch_all($params)
	{
		$sql   = "";
		$limit = "";
		$parameters = array();
		
		if ( ! in_array($params['order_by'], array('gallery.position')) )
			throw new Kohana_Exception('"'.$params['order_by']. '" is an invalid column for sorting results.');
			
		if ( ! in_array($params['sort'], array('ASC', 'DESC', 'RAND()')) )
			throw new Kohana_Exception('"sort" param must be either ASC, DESC or RAND(). "'.$params['sort'].'" given.');
		
		if (ctype_digit( (string) $params['status']))
		{
			$sql .= " AND gallery.status = :status";
			$parameters[':status'] = $params['status'];
		}
		if (ctype_digit( (string) $params['limit']) AND ctype_digit( (string) $params['offset']))
		{
			$limit = "LIMIT :offset, :limit";
			$parameters[':offset'] = $params['offset'];
			$parameters[':limit']  = $params['limit'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT SQL_CALC_FOUND_ROWS 
					gallery.id, 
					gallery.title, 
					gallery.summary, 
					gallery.title as name, 
					gallery.status, 
					IF(gallery.status=0, 'inactive', '') AS mode
				FROM 
					gallery
				LEFT JOIN 
					sys_lookup ON sys_lookup.code = gallery.status AND sys_lookup.type = 'status'
				WHERE 
					gallery.is_deleted = 0 
					".$sql."
				ORDER BY ".$params['order_by']." ".$params['sort']."
				".$limit."
			")
			->parameters($parameters)
			->execute();
		if($params['id']>0){
			$gallery= $data['gallery'] = DB::query(Database::SELECT, "
									SELECT gallery_media.id, gallery_media.gallery_id,
										gallery_media.title, gallery_media.summary, gallery_media.picture,
									CONCAT('/assets/files/gallery/',gallery_id,'/',picture, '') as src_file,
									CONCAT('/assets/files/gallery/',gallery_id,'/', picture) AS src_picture,
									gallery_media.status, gallery_media.is_deleted, gallery_media.log_id
									FROM gallery_media
									WHERE  gallery_id = :gallery_id
								")
								->parameters(array(':gallery_id' => $params['id']))
								->execute()->as_array();	
	}
		return $data;
	}

	public function fetch($params)
	{
		$sql = "";
		$parameters = array();

		if (ctype_digit( (string) $params['id']))
		{
			$sql .= " AND gallery.id = :id";
			$parameters[':id'] = $params['id'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT 
					gallery.id, 
					gallery.title, 
					gallery.title as name, 
					gallery.summary, 
					gallery.position,
					gallery.content_id,
					gallery.status,
					gallery.is_deleted,
					IF(gallery.status=0, 'inactive', '') AS mode
				FROM 
					gallery
				WHERE 
					gallery.is_deleted = 0 
					".$sql."
				LIMIT 1
			")
			->parameters($parameters)
			->execute()
			->current();
			if($params['id']>0){
			$gallery= $data['gallery'] = DB::query(Database::SELECT, "
									SELECT gallery_media.id, gallery_media.gallery_id,
										gallery_media.title, gallery_media.summary, gallery_media.picture,
									CONCAT('/assets/files/gallery/',gallery_id,'/',picture, '') as src_file,
									CONCAT('/assets/files/gallery/',gallery_id,'/', picture) AS src_picture,
									gallery_media.status, gallery_media.is_deleted, gallery_media.log_id
									FROM gallery_media
									WHERE  gallery_id = :gallery_id
								")
								->parameters(array(':gallery_id' => $params['id']))
								->execute()->as_array();	
	}
		if ($data)
		{
			$log  = Model::factory('Sys_Log_Activity')->last_modified($data['log_id']);
			$data = (array) $data + (array) $log;
			$data['date_created'] = Timestamp::format($data['date_created'], '%d/%b/%y %H:%M:%S');
		}
		
		return $data;
	}



	public function insert($data, $files)
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO gallery (title, summary, content_id, position, status, is_deleted, log_id) 
				VALUES (:title, :summary, :content_id, :position, :status, 0, 0)
			")
			->parameters(array(
				':title'    => $data['title'], 
				':summary'    => $data['summary'], 
				':content_id'    => $data['content_id'], 
				':position'  => $this->_position(), 
				':status'   => $data['status'],
			))
			->execute();
		
		$this->_insert_img($data, $id);
		
		return $id;
	}
	
	public function update($data, $files)
	{
		DB::query(Database::UPDATE, "
				UPDATE gallery
				SET
					title = :title, 
					summary = :summary,
					position= :position, 
					status = :status
				WHERE id = :id
			")
			->parameters(array(
				':title'     => $data['title'],
				':summary'   => $data['summary'],
				':position'  => $this->_position(), 
				':status'   => $data['status'],
				':id'        => $data['id'],
			))
			->execute();
			
		$this->_insert_img($data,$data['id'], 2);

		return $data['id'];
	}

	public function _insert_img($data, $gallery_id, $action=1){
		$update = false;
		if($action==2){
			$update=true;
			DB::query(Database::DELETE, "
						DELETE FROM gallery_media WHERE gallery_id = :gallery_id
					")
					->parameters(array(
						':gallery_id'      => $gallery_id,
					))
					->execute();
		}
		if(count($data['gallery-title'])>0){	
			
			for($i=0; $i<count($data['gallery-title']); $i++){
			
				$title = $data['gallery-title'][$i];
				$summary = $data['gallery-summary'][$i];
				$picture = $data['gallery-file'][$i];
				$tmpfile = $data['gallery-file'][$i];
				//var_dump($); exit; 

			
				$insert = DB::query(Database::INSERT, "
						INSERT INTO gallery_media (gallery_id, title, summary, picture, status, is_deleted)
						VALUES  (:gallery_id, :title, :summary, :picture, :status, :is_deleted)
					")
					->parameters(array(
						':gallery_id'      => $gallery_id,
						':type_id'       	=> 1,
						':title'       	=> $title,
						':summary'       	=> $summary,
						':picture'       	=> $picture,
						':status'       	=> 1,
						':is_deleted'       	=> 0,
						
					))
					->execute();
					//print'<pre>'; var_dump($i); print'</pre>'; exit;
		
			}
				foreach($data['gallery-file'] as $picture){
					if(!file_exists("assets/files/gallery/")){
						mkdir("assets/files/gallery/", 0777);
					}
					if(!file_exists("assets/files/gallery/".$gallery_id."/")){
						mkdir("assets/files/gallery/".$gallery_id."/", 0777);
					}
				$source      = 'assets/files/tmp/'.$picture;
				$destination = 'assets/files/gallery/'.$gallery_id.'/'.$picture;
						//var_dump($source); exit;
						if (file_exists($source) AND $picture !=''){
							copy($source, $destination);
							unlink($source);
						}	
			}
		}
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
				FROM gallery 
				WHERE is_deleted = 0 
				ORDER BY position DESC
				LIMIT 0,1
			")
			->execute()
			->get('position', 1);
	}
	

	public function sort($serialized)
	{
		
		$query = DB::query(Database::UPDATE, "UPDATE gallery SET position = :position WHERE id = :id")
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