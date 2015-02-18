<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sys_Module model. 
 *
 * @package    Contento
 * @category   Models
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Model_Sys_Module extends Model {
	
	public function menu($path)
	{
		$path = explode('/', $path);
		$menu = array();
		
		$user = Auth::instance()->get_user();
		
		if ($user)
		{
			$menu = DB::query(Database::SELECT, "SELECT id, name, directory, IF(directory=:directory, 'selected', '') AS selected FROM sys_module WHERE parent_id IS NULL ORDER BY position ASC")
				->parameters(array(
					':directory' => $path[1],
				))
				->execute()
				->as_array();
			
			$submenu = DB::query(Database::SELECT, "SELECT id, name, directory, description FROM sys_module WHERE parent_id = :parent_id AND id IN :modules ORDER BY position ASC")
				->parameters(array(
					':modules' => $user['modules'],
				))
				->bind(':parent_id', $parent_id);
				
			for($i=0; $i<count($menu); $i++)
			{
				$parent_id = $menu[$i]['id'];
				$menu[$i]['submenu'] = $submenu->execute()->as_array();
			}
		}
		
		return $menu;
	}
	
	public function get_title($param)
	{
		list($application, $directory, $controller, $action) = explode('/', $param);
		return DB::query(Database::SELECT, "
				SELECT m2.name
				FROM sys_module AS m2
				LEFT JOIN sys_module AS m1 ON m1.id = m2.parent_id
				WHERE m1.parent_id IS NULL AND m1.directory = :directory AND m2.directory = :controller
				LIMIT 0,1
			")
			->parameters(array(
				':directory' => $directory,
				':controller' => $controller,
			))
			->execute()
			->get('name', '');;
	}
	
	public function get_list($parent_id = NULL)
	{
		$modules = DB::query(Database::SELECT, "SELECT id, name, directory FROM sys_module WHERE parent_id IS NULL ORDER BY position ASC")->execute()->as_array();
		for ($i=0; $i<count($modules); $i++)
		{
			$modules[$i]['modules'] = DB::query(Database::SELECT, "SELECT id, name, directory FROM sys_module WHERE parent_id = :parent_id ORDER BY position ASC")->parameters(array(':parent_id' => $modules[$i]['id']))->execute()->as_array();
			for ($j=0; $j<count($modules[$i]['modules']); $j++)
			{
				$modules[$i]['modules'][$j]['permissions'] = DB::query(Database::SELECT, "SELECT action FROM sys_permissions WHERE module_id = :module_id")->parameters(array(':module_id' => $modules[$i]['modules'][$j]['id']))->execute()->as_array(NULL, 'action');
			}
		}
		return $modules;
	}
	
}