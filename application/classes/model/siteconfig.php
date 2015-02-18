<?php defined('SYSPATH') or die('No direct script access.');

class Model_Siteconfig extends Model {
	
	public function fetch_all($params)
	{
		$parameters = array();
		
		return DB::query(Database::SELECT, "
				SELECT SQL_CALC_FOUND_ROWS sc.id, sc.var_name, sc.var_description, sc.var_value, IF(sc.status=0, 'inactive', '') AS mode
				FROM siteconfig sc
				LEFT JOIN sys_lookup ON sys_lookup.code = sc.status AND sys_lookup.type = 'status'
				WHERE sc.is_deleted = 0
				ORDER BY sc.position ASC
			")
			->parameters($parameters)
			->execute()->as_array();
	}

	public function fetch($params)
	{
		$sql = "";
		$parameters = array();

		if (ctype_digit( (string) $params['id']))
		{
			$sql .= " AND slide.id = :id";
			$parameters[':id'] = $params['id'];
		}
		
		$data = DB::query(Database::SELECT, "
				SELECT sc.id, sc.var_name, sc.var_description, sc.var_value
				FROM siteconfig sc
				WHERE sc.is_deleted = 0 
					".$sql."
				LIMIT 1
			")
			->parameters($parameters)
			->execute()
			->current();
		
		return $data;
	}
	
	public function update($data, $files)
	{
		DB::query(Database::UPDATE, "
				UPDATE siteconfig
				SET var_value = :var_value
				WHERE var_name = :var_name
			")
			->parameters(array(
				':var_value'    => $data['var_value'],
				':var_name'     => $data['var_name'],
			))
			->execute();
		
		if($files):	
			$this->_upload_media($data['var_name'], $files, $data);
		endif;

		return $data['var_name'];
	}

	protected function _upload_media($var_name, $files, $data)
	{
		$media = array(
			$var_name => 'assets/files/siteconfig',
		);
		
		foreach ($media as $asset => $path)
		{		
			$file = Upload::save($_FILES[$asset], NULL, DOCROOT.$path);
			if ($file !== FALSE)
			{
				$file = basename($file);
				DB::query(Database::UPDATE, "UPDATE siteconfig SET var_value = :asset WHERE var_name = :var_name")
					->parameters(array(
						':asset' => $file, 
						':var_name'    => $var_name, 
					))
					->execute();
			}
			
			if ($data[$asset.'_del'])
			{
				DB::query(Database::UPDATE, "UPDATE site_config SET $asset = '' WHERE var_name = :var_name")->parameters(array(':var_name' => $var_name))->execute();
			}
		}
		
		return TRUE;
	}

}