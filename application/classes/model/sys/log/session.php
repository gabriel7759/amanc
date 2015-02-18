<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sys_Log_Session model. 
 *
 * @package    Contento
 * @category   Models
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Model_Sys_Log_Session extends Model {
	
	public function save($user_id, $action, $remote_address, $user_agent, $timestamp)
	{
		if ( ! $user_id)
			return FALSE;
		
		return DB::query(Database::INSERT, "
				INSERT INTO sys_log_session (user_id, action, remote_address, user_agent, timestamp)
				VALUES (:user_id, :action, INET_ATON(:remote_address), :user_agent, :timestamp)
			")
			->parameters(array(
				':user_id' => $user_id,
				':action' => $action,
				':remote_address' => $remote_address,
				':user_agent' => $user_agent,
				':timestamp' => $timestamp,
			))
			->execute();
	}
	
	/*
	public function latest($num, $user_id)
	{
		return DB::select('user_agent', 'INET_NTOA(remote_address)', 'timestamp', 'action')
			->from('sys_session_log')
			->where('user_id', '=', $user_id)
			->order_by('timestamp', 'DESC')
			->limit($num)
			->offset(0)
			->execute();
	}
	*/
	
}