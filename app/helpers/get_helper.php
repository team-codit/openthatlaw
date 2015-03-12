<?php
	
	/**
	* GET METHOD MANAGER
	*/
	class get_helper {

		static public function check($get_data, $ref)
		{
			$response = false;
			if (is_array($ref) && in_array($get_data, $ref))
				$response = true;
			else if (is_string($ref) || is_int($ref))
			{
				if ($ref != null && $get_data != $ref)
					$response = false;
				else
					$response = true;
			}
			if ($response)
				return(true);
			else
				return(get_helper::error());

		}
		
		static public function error()
		{
			header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request', true, 400);
			return(false);
		}

	}
