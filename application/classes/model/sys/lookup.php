<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sys_Lookup model. 
 *
 * @package    Contento
 * @category   Models
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Model_Sys_Lookup extends Model {
	
	public function get_name($type, $code)
	{
		return DB::select('name')
			->from('sys_lookup')
			->where('type', '=', $type)
			->where('code', '=', $code)
			->execute()
			->get('name', '');
	}
	
	public function get_code($type, $name)
	{
		return DB::select('code')
			->from('sys_lookup')
			->where('type', '=', $type)
			->where('name', '=', $name)
			->execute()
			->get('code', '');
	}
	
	public function fetch_by_type($type)
	{
		return DB::select('code', 'name')
			->from('sys_lookup')
			->where('type', '=', $type)
			->order_by('position', 'ASC')
			->execute();
	}
	
}