<?php defined('SYSPATH') or die('No direct script access.');

class Model extends Kohana_Model {
	
	public function delete($id, $controller)
	{
//		$table = strtolower(str_replace('Model_', '', get_called_class()));
		$table = strtolower($controller);
		if($table == 'admins')
			$table = "sys_user";
		else if($table == 'roles')
			$table = "sys_role";
		
		return DB::query(Database::UPDATE, "UPDATE ".mysql_real_escape_string($table)." SET is_deleted = 1 WHERE id = :id")
			->parameters(array(
				':id' => $id,
			))
			->execute();
	}
	
	public function status($id, $status)
	{
		$table = strtolower(str_replace('Model_', '', get_called_class()));
		
		return DB::query(Database::UPDATE, "UPDATE ".mysql_real_escape_string($table)." SET status = :status WHERE id = :id")
			->parameters(array(
				':status' => $status,
				':id' => $id,
			))
			->execute();
	}
	
}
