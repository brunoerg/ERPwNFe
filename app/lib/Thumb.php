<?php
/*
 * MŽtodo geraThumb
 * Gera thumbnail a partir da foto
 */

class Thumb {
	function __construct(){

	}

	public function resize($photo, $output, $new_width) {
		$new_width = 220;

		$source = imagecreatefromstring(file_get_contents($photo));
		list($width, $height) = getimagesize($photo);
		if ($width>$new_width)
		{
			//$new_height = ($new_width/$width) * $height;
			$new_height = 170;
			$thumb = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($thumb, $source, 0, 0, 0, 0,$new_width, $new_height, $width, $height);
			imagejpeg($thumb, $output, 100);
			return true;
		}
		else
		{
			copy($photo, $output);
		}
	}


}
