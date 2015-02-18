<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sys_Role model. 
 *
 * @package    Contento
 * @category   Models
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Model_Sys_Role extends Model {
	
	/**
 	* Internal roles constants. See sys_role table.
 	*/
	const SYSTEM = 1;
	const GUEST  = 2;
	
	public function fetch_all($params)
	{
		$sql   = "";
		$limit = "";
		$parameters = array();
		
		if ( ! in_array($params['order_by'], array('sys_role.name', 'sys_role.last_modified', 'status')) )
			throw new Kohana_Exception('"'.$params['order_by']. '" is an invalid column for sorting results.');
			
		if ( ! in_array($params['sort'], array('ASC', 'DESC', 'RAND()')) )
			throw new Kohana_Exception('"sort" param must be either ASC, DESC or RAND(). "'.$params['sort'].'" given.');
		
		if (ctype_digit( (string) $params['status']))
		{
			$sql .= " AND sys_role.status = :status";
			$parameters[':status'] = $params['status'];
		}
		if ( ! empty($params['text']))
		{
			$sql .= " AND sys_role.name LIKE :text";
			$parameters[':text'] = '%'.$params['text'].'%';
		}
		if (ctype_digit( (string) $params['limit']) AND ctype_digit( (string) $params['offset']))
		{
			$limit = "LIMIT :offset, :limit";
			$parameters[':offset'] = $params['offset'];
			$parameters[':limit']  = $params['limit'];
		}
		
		return DB::query(Database::SELECT, "
				SELECT SQL_CALC_FOUND_ROWS sys_role.id, sys_role.name, sys_lookup.name AS status, IF(sys_role.status=0, 'inactive', '') AS mode, 
						sys_role.last_modified
				FROM sys_role 
				LEFT JOIN sys_lookup ON sys_lookup.code = sys_role.status AND sys_lookup.type = 'status'
				WHERE sys_role.is_deleted = 0 AND sys_role.system = 0 ".$sql."
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
			$sql .= " AND sys_role.id = :id";
			$parameters[':id'] = $params['id'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT sys_role.id, sys_role.name, sys_role.status, sys_role.log_id
				FROM sys_role
				WHERE sys_role.is_deleted = 0 ".$sql."
			")
			->parameters($parameters)
			->execute()
			->current();
		
		if ($data)
		{
			$log = Model::factory('Sys_Log_Activity')->last_modified($data['log_id']);
			$data = (array) $data + (array) $log;
			
			$data['access_control'] = DB::query(Database::SELECT, "
				SELECT CONCAT(module_id, '.', action) AS permission FROM sys_access_control WHERE role_id = :role_id
			")
			->parameters(array(
				':role_id' => $data['id']
			))
			->execute()
			->as_array(NULL, 'permission');
		}
		
		return $data;
	}
	
	public function insert($data)
	{
		list($id) = DB::query(Database::INSERT, "
				INSERT INTO sys_role (name, last_modified, date_created, status)
				VALUES (:name, :last_modified, :date_created, :status)
			")
			->parameters(array(
				':name'          => $data['name'],
				':last_modified' => time(),
				':date_created'  => time(),
				':status'        => $data['status'],
			))
			->execute();
		
		$this->_add_permissions($id, $data);
		
		return $id;
	}
	
	public function update($data)
	{
		DB::query(Database::UPDATE, "
				UPDATE sys_role 
				SET name = :name, last_modified = :last_modified, status = :status
				WHERE id = :id
			")
			->parameters(array(
				':name'          => $data['name'],
				':last_modified' => time(),
				':status'        => $data['status'],
				':id'            => $data['id'],
			))
			->execute();
		
		$this->_add_permissions($data['id'], $data);
		
		return $data['id'];
	}
	
	protected function _add_permissions($role_id, $data)
	{	
		DB::query(Database::DELETE, "DELETE FROM sys_access_control WHERE role_id = :role_id")->parameters(array(':role_id' => $role_id))->execute();
	
		$query = DB::query(Database::INSERT, "
					  INSERT INTO sys_access_control (role_id, module_id, action) VALUES (:role_id, :module_id, :action)
				")
			->param(':role_id', $role_id)
			->bind(':module_id', $module_id)
			->bind(':action', $action);
		
		foreach ($data['access_control'] as $permission)
		{
			list($module_id, $action) = explode('.', $permission);
			$query->execute();
		}
	}
	
	public static function validate($data)
	{
		$data = (array) $data;
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('name', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(0, 1)));

		return $data;
	}
	
}