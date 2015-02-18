<?php
defined('SYSPATH') or die('No direct script access.');

class Model_Image extends Model {
	
	private $_data = array(
		'image'=>'',
		'maxWidth'=>68,
		'maxHeight'=>68,
		'target'=>''
	);
	
	private $_sourceimagedata = array(
		'image'=>'',
		'width'=>0,
		'height'=>0,
		'extension'=>''
	);
	private $_newimagedata = array(
		'image'=>'',
		'coords'=>array(),
		'targetname'=>'',
		'targetfullpath'=>''
	);
	
	public function set($key, $value = NULL)
	{
		if (is_array($key))
		{
			foreach ($key as $name => $value)
			{
				$this->_data[$name] = $value;
			}
		}
		else
		{
			$this->_data[$key] = $value;
		}

		return $this;
	}

	private function get_source_info()
	{
		$imginfo = getimagesize($this->_data['image']);
		
		$this->_sourceimagedata['width'] = $imginfo[0];
		$this->_sourceimagedata['height'] = $imginfo[1];
		$this->_sourceimagedata['extension'] = strtolower(image_type_to_extension($imginfo[2], false));
		
	}

	private function set_targetname()
	{
		$imagename = basename($this->_data['image']);
		
		$this->_newimagedata['targetname'] = $imagename;
		$this->_newimagedata['targetfullpath'] = $this->_data['target'].$imagename;
		
	}

	private function create_image_from_source()
	{
		switch($this->_sourceimagedata['extension']){
			case "gif": // GIF
					$this->_sourceimagedata['image'] = imagecreatefromgif($this->_data['image']);
				break;
			case "jpeg": // JPEG
			case "jpg": // JPEG
					$this->_sourceimagedata['image'] = imagecreatefromjpeg($this->_data['image']);
				break;
			case "png": // PNG
					$this->_sourceimagedata['image'] = imagecreatefrompng($this->_data['image']);
				break;
			default:
					$this->returnError("Invalid source format");
				break;
		}
	}

	private function create_image($width, $height)
	{
		$this->_newimagedata['image'] = imagecreatetruecolor($width, $height);
		if($this->_sourceimagedata['extension'] == 'png')
			imagealphablending($this->_newimagedata['image'], false);
	}

	private function set_image_data($coords)
	{
		imagecopyresampled($this->_newimagedata['image'], $this->_sourceimagedata['image'], $coords[0], $coords[1], $coords[2], $coords[3], $coords[4], $coords[5], $coords[6], $coords[7]);
	}

	private function save_image()
	{
		switch($this->_sourceimagedata['extension']){
			case "gif": // GIF
			    	$fullImage = imagegif($this->_newimagedata['image'], $this->_newimagedata['targetfullpath']);
				break;
			case "jpeg": // JPEG
			case "jpg": // JPEG
			    	$fullImage = imagejpeg($this->_newimagedata['image'], $this->_newimagedata['targetfullpath'], 80);
				break;
			case "png": // PNG
					imagesavealpha($this->_newimagedata['image'], true);
			    	$fullImage = imagepng($this->_newimagedata['image'], $this->_newimagedata['targetfullpath'], round((80/10)));
				break;
			default:
					$this->returnError("Invalid source format");
				break;
		}

	    ImageDestroy($this->_newimagedata['image']);
	}

	public function create_thumbnail()
	{
		$this->get_source_info();
		$this->set_targetname();
		$this->create_image_from_source();

		/**** Get new image cords *****/
			$tempheight = floor($this->_data['maxHeight'] * $this->_sourceimagedata['width'] / $this->_data['maxWidth']);
			$tempwidth = $this->_sourceimagedata['width'];
		
			if($tempheight > $this->_sourceimagedata['height']){
				$tempheight = $this->_sourceimagedata['height'];
				$tempwidth = floor($this->_data['maxWidth'] * $this->_sourceimagedata['height'] / $this->_data['maxHeight']);
			}
		
			$origCoords = array('x'=>floor(($this->_sourceimagedata['width'] - $tempwidth) / 2), 'y'=>floor(($this->_sourceimagedata['height'] - $tempheight) / 2));
			$coords = array(0, 0, $origCoords['x'], $origCoords['y'], $this->_data['maxWidth'], $this->_data['maxHeight'], $tempwidth, $tempheight);
		/**** Done ****/

		$this->create_image($this->_data['maxWidth'], $this->_data['maxHeight']);
		$this->set_image_data($coords);
		$this->save_image();
		
		return $this->_newimagedata['targetfullpath'];
		
	}

	public function resize()
	{
		$this->get_source_info();
		$this->set_targetname();
		$this->create_image_from_source();

		/**** Get new image cords *****/
		
		if($this->_sourceimagedata['width'] <= $this->_data['maxWidth'] && $this->_sourceimagedata['height'] <= $this->_data['maxHeight']){
			// Image is smaller/equal than the specified size
			$origCoords = array('x'=>0, 'y'=>0);
			
			$tempwidth = $this->_sourceimagedata['width'];
			$tempheight = $this->_sourceimagedata['height'];
			$coords = array(0, 0, 0, 0, $tempwidth, $tempheight, $this->_sourceimagedata['width'], $this->_sourceimagedata['height']);
		} else{
			// Image is bigger than the specified size
			
			$tempheight = $this->_sourceimagedata['height'] * $this->_data['maxWidth'] / $this->_sourceimagedata['width'];
			$tempwidth = $this->_data['maxWidth'];
			
			if($tempheight > $this->_data['maxHeight']){
				$tempwidth = $this->_sourceimagedata['width'] * $this->_data['maxHeight'] / $this->_sourceimagedata['height'];
				$tempheight = $this->_data['maxHeight'];
			}
			
			$coords = array(0, 0, 0, 0, $tempwidth, $tempheight, $this->_sourceimagedata['width'], $this->_sourceimagedata['height']);
		
		}
		
		/**** Done ****/

		$this->create_image($tempwidth, $tempheight);
		$this->set_image_data($coords);
		$this->save_image();
		
		return $this->_newimagedata['targetfullpath'];
		
	}


}