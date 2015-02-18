<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sys_Log_Activity model. 
 *
 * @package    Contento
 * @category   Models
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Model_Sys_Log_Activity extends Model {
	
	public function last_modified($id)
	{	
		return DB::query(Database::SELECT, "
				SELECT sys_log_activity.timestamp AS log_time, CONCAT(sys_user.first_name, ' ', sys_user.last_name) AS log_user
				FROM sys_log_activity 
				LEFT JOIN sys_user ON sys_user.id = sys_log_activity.user_id
				WHERE sys_log_activity.id = :id
				ORDER BY sys_log_activity.timestamp DESC
				LIMIT 1
			")
			->parameters(array(
				':id' => $id,
			))
			->execute()
			->current();
	}
	
	/*
	public function get_flash_msg($session_var)
	{
		$session = Session::instance();
		
		if ( ! ($id = $session->get($session_var)))
			return '';
		
		$result = DB::select('sm.flash', 'sal.object_name', 'sal.action')
			->from(array('sys_activity_log', 'sal'))
			->join(array('sys_module', 'sm'))
			->on('sm.id', '=', 'sal.module_id')
			->where('sal.id', '=', $id)
			->execute()
			->current();
		
		$action = Model::factory('Sys_Lookup')->get_name('activity', $result['action']);
		$action = str_replace("ar", "ad", strtolower($action));
		
		$flash = $result['flash'];
		$flash = str_replace("{object_name}", $result['object_name'], $flash);
		$flash = str_replace("{action}", $action, $flash);
		
		if ($result['action'] == 3)
		{
			$qs = (strpos($_SERVER['REQUEST_URI'], '?') !== FALSE) ? '&' : '?';
			$flash .= '<a href="'.$_SERVER['REQUEST_URI'].$qs.'undo=true" class="undo">Undo</a>';
			$session->set('undo', $id);
		}
		
		$session->delete($session_var);
		
		return $flash;
	}
	
	public function latest($num, $user_id)
	{
		return DB::select(array('sm.name', 'module_name'), 'sal.object_name', 'sal.timestamp', 'sal.action')
			->from(array('sys_activity_log', 'sal'))
			->join(array('sys_module', 'sm'))
			->on('sm.id', '=', 'sal.module_id')
			->where('sal.user_id', '=', $user_id)
			->order_by('sal.timestamp', 'DESC')
			->limit($num)
			->offset(0)
			->execute();
	}
	
	public function check_undo()
	{
		$session = Session::instance();
		$undo = Arr::get($_GET, 'undo', '');
		$id = (int) $session->get('undo');
		
		if ($id AND $undo)
		{
			$result = DB::select('sal.object_id', 'sm.table', 'sal.data')
				->from(array('sys_activity_log', 'sal'))
				->join(array('sys_module', 'sm'))
				->on('sm.id', '=', 'sal.module_id')
				->where('sal.id', '=', $id)
				->execute()
				->current();
				
			DB::delete('sys_activity_log')->where('id', '=', $id)->execute();
			
			DB::update($result['table'])->set(array('is_deleted' => 0))->where('id', '=', $result['object_id'])->execute();
			
			$session->delete('undo');
		}
	}
	*/
	
}