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
class Model_State extends Model {
	
	public function fetch($params){
		$parameters = array();
		$where = '';

		if($params['id']){
			$where .= ' AND id=:id';
			$parameters[':id'] = $params['id'];
		}
		if($params['slug']){
			$where .= ' AND slug=:slug';
			$parameters[':slug'] = $params['slug'];
		}	
		return DB::query(Database::SELECT, "
			SELECT id, state, slug
			FROM state 
			WHERE 1 ".$where."
			ORDER BY state ASC")->parameters($parameters)->execute()->current();
	}
	public function fetch_all($params)
	{
		$parameters = array();		
		return DB::query(Database::SELECT, "
			SELECT id, state, slug
			FROM state 
			WHERE 1
			ORDER BY state ASC")->parameters($parameters)->execute()->as_array();
	}	
	
}