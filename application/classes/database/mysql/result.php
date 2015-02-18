<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Extends Kohana_Database_MySQL_Result with custom Contento methods.
 *
 * @package    Contento/Database
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Database_MySQL_Result extends Kohana_Database_MySQL_Result {
	
	/**
	 * Get the found rows from the query. Useful when working with LIMIT and pagination.
	 * 
	 * SQL_CALC_FOUND_ROWS must be provided along with the SELECT statement. For example:
	 * 
	 *     // Suppose we have 135 rows in the table
	 *     $result = DB::query(Database::SELECT, "SELECT id, name FROM table LIMIT 0,10");
	 *     echo $result->found_rows(); // Will output 10
	 *     $result2 = DB::query(Database::SELECT, "SELECT SQL_CALC_FOUND_ROWS id, name FROM table LIMIT 0,10");
	 *     echo $result2->found_rows(); // Will output 135
	 *
	 * @return  integer Found rows
	 */
	public function found_rows()
	{
		return (int) DB::query(Database::SELECT, "SELECT FOUND_ROWS() AS found_rows")->execute()->get('found_rows');
	}
	
}
