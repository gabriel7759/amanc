<?php defined('SYSPATH') or die('No direct script access.');

class Model_Content extends Model {
	
	public function fetch_all()
	{
		$id_parent = 0;
		
		$query = DB::query(Database::SELECT, "
				SELECT content.id, content.title, sys_lookup.name AS status, IF(content.status=0, 'inactive', '') AS mode
				FROM content
				LEFT JOIN sys_lookup ON sys_lookup.code = content.status AND sys_lookup.type = 'status'
				WHERE content.is_deleted = 0 
						AND content.id_parent = :id_parent
				ORDER BY content.position ASC
			")
			->bind(':id_parent', $id_parent);
		
		$pages = $query->execute()->as_array();
	
		for ($i=0; $i<count($pages); $i++)
		{
			$id_parent = $pages[$i]['id'];
			$pages[$i]['pages'] = $query->execute()->as_array();
			
			for ($j=0; $j<count($pages[$i]['pages']); $j++)
			{
				$id_parent = $pages[$i]['pages'][$j]['id'];
				$pages[$i]['pages'][$j]['pages'] = $query->execute()->as_array();
			}
		}
		return $pages;
	}
	
	public function fetch($params)
	{
		$sql = "";
		$parameters = array();

		if (ctype_digit( (string) $params['id']))
		{
			$sql .= " AND content.id = :id";
			$parameters[':id'] = $params['id'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT content.id,
					content.id_parent,
					content.title,
					content.title AS name,
					content.subtitle,
					content.url,
					content.content,
					content.link,
					content.status, 
					content.in_menu, 
					content.log_id,
					content.seo_title, content.seo_keywords, content.seo_abstract, content.seo_description
				FROM content
				WHERE content.is_deleted = 0 ".$sql."
			")
			->parameters($parameters)
			->execute()
			->current();
		
		if ($data)
		{
			$log = Model::factory('Sys_Log_Activity')->last_modified($data['log_id']);
			$data = (array) $data + (array) $log;
		}
		
		return $data;
	}
	
	public function fetchbyuri($section, $page, $subpage)
	{
		$sql = "";
		$parameters = array();

		$sql .= " AND url = :text AND id_parent = :id_parent";
		$parameters[':text'] = $section;
		$parameters[':id_parent'] = 0;
		
		$data = DB::query(Database::SELECT, "
				SELECT
					content.id, 
					content.title as maintitle,
					content.title,
					content.subtitle,
					content.url, 
					content.content,
					1 as level
				FROM 
					content
				WHERE 
					content.is_deleted = 0
					AND content.status = 1
					AND id_parent = 0
					".$sql."
				LIMIT 1
			")
			->parameters($parameters)
			->execute()
			->current();
		
		if($page){
			$sql = "";
			$parameters = array();

			$sql .= " AND content.url = :text AND content.id_parent = :id_parent";
			$parameters[':text'] = $page;
			$parameters[':id_parent'] = $data['id'];
		
			$data = DB::query(Database::SELECT, "
					SELECT
						content.id, 
						content.title,
						content.subtitle,
						main.title as maintitle,
						content.url, 
						content.content,
						2 as level
					FROM 
						content
						LEFT JOIN content as main ON main.id = content.id_parent
					WHERE 
						content.is_deleted = 0
						AND content.status = 1
						".$sql."
					LIMIT 1
				")
				->parameters($parameters)
				->execute()
				->current();

			if($subpage){
				$sql = "";
				$parameters = array();

				$sql .= " AND content.url = :text AND content.id_parent = :id_parent";
				$parameters[':text'] = $subpage;
				$parameters[':id_parent'] = $data['id'];
		
				$data = DB::query(Database::SELECT, "
						SELECT
							content.id, 
							content.title,
							content.subtitle,
							main.title as maintitle,
							content.url, 
							content.content,
							3 as level
						FROM 
							content
							LEFT JOIN content as main ON main.id = content.id_parent
						WHERE 
							content.is_deleted = 0
							AND content.status = 1
							".$sql."
						LIMIT 1
					")
					->parameters($parameters)
					->execute()
					->current();
			}
/*
			if($data){
				$data['subs'] = DB::query(Database::SELECT, "
						SELECT
							content.id, 
							content.title,
							content.subtitle,
							content.content,
							content.url
						FROM 
							content
						WHERE 
							content.is_deleted = 0
							AND content.status = 1
							AND content.id_parent = :parent_id
					")
					->parameters(array(":parent_id"=>$data['id']))
					->execute()
					->as_array();
				}
*/
		}

		return $data;
	}

	public function insert($data, $files)
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO content (id_parent, title, subtitle, url, content, link, position, status, in_menu, seo_title, seo_keywords, seo_abstract, seo_description)
				VALUES (:parent_id, :title, :subtitle, :slug, :content, :link, :position, :status, :in_menu, :seo_title, :seo_keywords, :seo_abstract, :seo_description)
			")
			->parameters(array(
				':parent_id'     	=> $data['parent_id'],
				':title'         	=> $data['title'],
				':subtitle'      	=> $data['subtitle'],
				':slug'          	=> $data['slug'],
				':content'       	=> $data['content'],
				':link'          	=> $data['link'],
				':position'      	=> $this->_position($data['parent_id']),
				':status'       	=> $data['status'],
				':in_menu'        	=> (($data['parent_id']==0)?$data['in_menu']:0),
				':seo_title'     	=> $data['seo_title'],
				':seo_keywords'  	=> $data['seo_keywords'],
				':seo_abstract'     => $data['seo_abstract'],
				':seo_description'  => $data['seo_description'],				
			))
			->execute();

		return $id;
	}
	
	public function update($data, $files)
	{
		DB::query(Database::UPDATE, "
				UPDATE content 
				SET
					id_parent 		= :parent_id,
					title			= :title,
					subtitle 		= :subtitle,
					url 			= :slug,
					content 		= :content,
					link 			= :link,
					in_menu 		= :in_menu,
					status 			= :status,
					seo_title 		= :seo_title,
					seo_keywords 	= :seo_keywords,
					seo_abstract 	= :seo_abstract,
					seo_description = :seo_description					
				WHERE id = :id
			")
			->parameters(array(
				':parent_id'     	=> $data['parent_id'],
				':title'         	=> $data['title'],
				':subtitle'      	=> $data['subtitle'],
				':slug'          	=> $data['slug'],
				':content'       	=> $data['content'],
				':link'          	=> $data['link'],
				':status'        	=> $data['status'],
				':in_menu'        	=> (($data['parent_id']==0)?$data['in_menu']:0),
				':seo_title'     	=> $data['seo_title'],
				':seo_keywords'  	=> $data['seo_keywords'],
				':seo_abstract'     => $data['seo_abstract'],
				':seo_description'  => $data['seo_description'],				
				':id'            	=> $data['id'],
			))
			->execute();
			
		return $data['id'];
	}
	


	private function _position($parent_id = 0)
	{
		return DB::query(Database::SELECT, "
				SELECT (position + 1) AS position 
				FROM content 
				WHERE is_deleted = 0 
						AND id_parent = :parent_id
				ORDER BY position DESC
				LIMIT 0,1
			")
			->parameters(array(
				':parent_id' => $parent_id,
			))
			->execute()
			->get('position', 1);
	}
	
	public function sort($serialized)
	{
		$query = DB::query(Database::UPDATE, "UPDATE content SET position = :position, id_parent = :parent_id WHERE id = :id")
			->bind(':position', $position)
			->bind(':parent_id', $parent_id)
			->bind(':id', $id);
		
		$i = $j = 1;
		foreach ($serialized['item'] as $id => $parent_id)
		{
			if ($parent_id == 'root') // First level
			{
				$j = 1;
				$parent_id = NULL;
				$position = $i;
				$query->execute();
				$i++;
			}
			else // Second level
			{
				$position = $j;
				$query->execute();
				$j++;
			}
			
		}
	}
	
	public static function validate($data)
	{
		$data = (array) $data;
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('parent_id', 'digit')
			->rule('title', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(0, 1)));

		return $data;
	}
	
	public function get_sections()
	{
		$id_parent = 0;
		
		$query = DB::query(Database::SELECT, "
				SELECT id, title, 2 as level FROM content WHERE is_deleted = 0 AND id_parent = :id_parent ORDER BY position ASC")
			->bind(':id_parent', $id_parent);
		
		$pages = $query->execute()->as_array();
	
		for ($i=0; $i<count($pages); $i++)
		{
			$id_parent = $pages[$i]['id'];
			$pages[$i]['level'] = 1;
			$pages[$i]['pages'] = $query->execute()->as_array();
			
			for ($j=0; $j<count($pages[$i]['pages']); $j++)
			{
				$id_parent = $pages[$i]['pages'][$j]['id'];
				$pages[$i]['pages'][$j]['pages'] = $query->execute()->as_array();
			}
		}
		return $pages;

	}
	
	
	public static function menu($menu, $children = NULL)
	{
		$menu = DB::query(Database::SELECT, "SELECT id, title, url, link FROM content WHERE deleted = 0 AND parent_id = 0 ORDER BY position ASC")->execute()->as_array();
		
		if ($children)
		{
			for ($i=0; $i<count($menu); $i++)
			{
				$menu[$i]['submenu'] = DB::query(Database::SELECT, "SELECT id, title, url, link FROM content WHERE deleted = 0 AND parent_id = :parent_id ORDER BY position ASC")
					->param(':parent_id', $menu[$i]['id'])
					->execute();
			}
		}
		
		return $menu;
	}
	
	
	public function get_page($params)
	{
		$sql = "";
		$parameters = array();

		if (! empty($params['section']))
		{
			$sql .= " AND page.slug = :section";
			$parameters[':section'] = $params['section'];
		}
		
		return DB::query(Database::SELECT, "
				SELECT page.id, page.parent_id, page.title, page.subtitle, page.title AS name, page.slug, page.summary, page.content, page.link, page.status, 
					page.log_id
				FROM page
				WHERE page.deleted = 0 ".$sql."
			")
			->parameters($parameters)
			->execute()
			->current();
	}

	public function fetch_menu()
	{
		$data = DB::query(Database::SELECT, "
				SELECT
					id,
					title,
					url,
					link,
					in_menu
				FROM 
					content
				WHERE 
					is_deleted = 0 
					AND status = 1
					AND id_parent = 0
				ORDER BY position ASC
			")
			->execute()
			->as_array();
		for($i=0; $i<count($data); $i++){
			
			if($data[$i]['id'] == 4){
				$data[$i]['link'] = $data[$i]['url'];
				//$data[$i]['sub'] = Model::factory('Blogcats')->fetch_menu();
			} else {
			$data[$i]['sub'] = DB::query(Database::SELECT, "
					SELECT
						id,
						title,
						url,
						link
					FROM 
						content
					WHERE 
						is_deleted = 0 
						AND status = 1
						AND id_parent = '".$data[$i]['id']."'
					ORDER BY position ASC
				")
				->execute()
				->as_array();
			if(strlen($data[$i]['link'])==0)
				$data[$i]['link'] = $data[$i]['url'];
			for($j=0; $j<count($data[$i]['sub']); $j++){
				if(strlen($data[$i]['sub'][$j]['link'])==0)
					$data[$i]['sub'][$j]['link'] = $data[$i]['url'].'/'.$data[$i]['sub'][$j]['url'];

				$data[$i]['sub'][$j]['sub'] = DB::query(Database::SELECT, "
						SELECT
							id,
							title,
							url,
							link
						FROM 
							content
						WHERE 
							is_deleted = 0 
							AND status = 1
							AND id_parent = '".$data[$i]['sub'][$j]['id']."'
						ORDER BY position ASC
					")
					->execute()
					->as_array();
				for($k=0; $k<count($data[$i]['sub'][$j]['sub']); $k++){
					if(strlen($data[$i]['sub'][$j]['sub'][$k]['link'])==0)
						$data[$i]['sub'][$j]['sub'][$k]['link'] = $data[$i]['url'].'/'.$data[$i]['sub'][$j]['url'].'/'.$data[$i]['sub'][$j]['sub'][$k]['url'];
				}
		}

		}
		}
		return $data;
	}
	
	
	public function fetch_childrens($params)
	{
		$sql = "";
		$parameters = array();

		if (ctype_digit( (string) $params['id_parent']))
		{
			$sql .= " AND t1.id_parent = :id_parent";
			$parameters[':id_parent'] = $params['id_parent'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT t1.id,
					t1.id_parent,
					t1.title,
					t1.title AS name,
					t1.subtitle,
					IF(t1.link ='', CONCAT(t2.url, '/', t1.url), t1.link) as href,
					t1.content,
					t1.link,
					t1.status, 
					t1.in_menu, 
					t1.log_id,
					t1.seo_title, t1.seo_keywords, t1.seo_abstract, t1.seo_description
				FROM content t1
				LEFT JOIN content t2 ON t1.id_parent = t2.id
				WHERE t1.is_deleted = 0 ".$sql."
			")
			->parameters($parameters)
			->execute();
		
		return $data;
	}
	
	
}