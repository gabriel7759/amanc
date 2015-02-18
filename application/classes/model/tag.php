<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Page model. 
 *
 * @package    Contento
 * @category   Models
 * @author     Abargon
 * @copyright  (c) 2013 Abargon
 * @license    http://abargon.com
 */
class Model_Tag extends Model {
	public function get_by_content($data){
		$parameters = array();
		$where = '';	
		if (ctype_digit( (string) $data['module'])){
			$where .= ' AND t2.module_id = :module';
			$parameters[':module'] = $data['module'];
		}
		if($where){
			return DB::query(Database::SELECT, "SELECT DISTINCT t1.id, t1.title
											FROM tag t1
											INNER JOIN tag_content t2 ON t1.id = t2.tag_id
											WHERE is_deleted = 0 AND status = 1 ".$where)->parameters($parameters)->execute()->as_array();
		}
	}
	
	public function fetch_all($params) 
	{
		$parameters = array();		
		if (ctype_digit( (string) $params['status'])) 
		{
			$parameters[':status'] = $params['status'];
		}
		
		return DB::query(Database::SELECT, "SELECT id, title, status, is_deleted
											FROM tag
											WHERE is_deleted = 0 AND status = :status ORDER BY title")->parameters($parameters)->execute()->as_array();
	}
	
	public function fetch_deps($params) 
	{
		$parameters = array();
		$sql="";

		return DB::query(Database::SELECT, "SELECT id, module_id, content_id, tag_id 
											FROM tag_content 
											WHERE deleted = 0 and status = 1 ".$sql." ORDER BY title")->parameters($parameters)->execute();
	}
	
	public function fetch($params) 
	{
		$sql = "";
		$parameters = array();
		
		if (ctype_digit( (string) $params['id']))
		{
			$parameters[':id'] = $params['id']; 
		}

		$data = DB::query(Database::SELECT, "
				SELECT id, title, title as name, status, is_deleted
				FROM tag 
				WHERE id = :id ".$sql)
			->parameters($parameters)->execute()->current();
			
					
		return $data;
	}
	
	public function insert($data) 
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO tag (title, status, is_deleted)
				VALUES (:title, :status, :is_deleted)
			")
			->parameters(array(
				':title'          => $data['title'],
				':status'        => $data['status'],
				':deleted'        => 0,
			))->execute();
		return $id;
	}
	
	public function update($data) 
	{
		DB::query(Database::UPDATE, "
				UPDATE tag 
				SET title = :title, title = :title, status = :status
				WHERE id = :id
			")
			->parameters(array(
				':title'          => $data['title'],
				':status'        => $data['status'],
			))
			->execute();
			
		return $data['id'];
	}
	
	//front---->
	public function fetch_tag($params)
	{
		$parameters = array();
		if (ctype_digit( (string) $params['status'])){
			$sql .= " AND t1.status = :status";
			$parameters[':status'] = $params['status'];
		}

		$tag = DB::query(Database::SELECT, "
						Select t1.*, t1.title
						FROM tag t1
						INNER JOIN tag_content t2 ON t1.id = t2.tag_id
						WHERE t1.is_deleted = 0 ".$sql)->parameters($parameters)->execute()->as_array();
		return $tag;
	}
}