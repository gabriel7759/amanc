<?php defined('SYSPATH') or die('No direct script access.');

class Model_Sys_Setting extends Model {
	
	public function fetch_all()
	{
		$settings = array();
		
		$results = DB::query(Database::SELECT, "
				SELECT 
					var, 
					value 
				FROM 
					sys_setting
			")
			->execute()
			->as_array();
			
		foreach ($results as $result)
		{
			$settings[$result['var']] = $result['value'];
		}
		
		return $settings;
	}
	
	public static function value($var)
	{
		return DB::query(Database::SELECT, "
				SELECT 
					value 
				FROM 
					sys_setting
				WHERE
					var = :var
			")
			->parameters(array(
				':var' => $var, 
			))
			->execute()
			->get('value', NULL);
	}
	
	public static function update($data)
	{
		foreach ($data as $var => $value)
		{
			if (strtotime($value) !== FALSE)
			{
				DB::update('sys_setting')->set(array('value' => strtotime($value)))->where('var', '=', $var)->execute();
			}
			else
			{
				DB::update('sys_setting')->set(array('value' => $value))->where('var', '=', $var)->execute();
			}
		}
		
		$media = array(
		);
		
		foreach ($media as $asset => $path)
		{	
			if (Upload::save($_FILES[$asset], $_FILES[$asset]['name'], DOCROOT.$path) !== FALSE)
			{
				DB::query(Database::UPDATE, "UPDATE sys_setting SET value = :value WHERE var = :var")
					->parameters(array(
						':value' => $_FILES[$asset]['name'], 
						':var'   => $asset, 
					))
					->execute();
				
			}
			
			if ($data[$asset.'_del'])
			{
				DB::query(Database::UPDATE, "UPDATE sys_setting SET value = '' WHERE var = :var")
					->parameters(array(
						':var' => $var, 
					))
					->execute();
			}
		}
		
		return TRUE;
	}

}