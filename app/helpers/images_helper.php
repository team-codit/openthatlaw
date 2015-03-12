<?php

class images_helper
{

	static public function save($url = null, $path, $name)
	{
		$replace			= [
			'_thumb'		=> '/r_x_380/b_1_000000/pictures/',
			'_poster'		=> '/r_x_600/b_1_000000/pictures/'
		];
		foreach ($replace as $ext => $replace)
		{
			if (!file_exists($path . $name . $ext . '.jpg'))
			{
				$current_url	= (isset($url)) ? str_replace('/pictures/', $replace, $url) : 'http://scimath.unl.edu/csmce/images/directory/noimage.jpg';
				$im1			= imagecreatefromjpeg($current_url);
				$im2			= imagecreatetruecolor(imagesx($im1), imagesy($im1));
				imagecopyresampled($im2, $im1, 0, 0, 0, 0, imagesx($im2), imagesy($im2), imagesx($im1), imagesy($im1));
				imagejpeg($im1, $path . $name . $ext . '.jpg');
				imagedestroy($im1);
			}
		}
	}
	
	
}