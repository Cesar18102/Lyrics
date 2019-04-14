<?php

	function GetImgs() {
		
		$pictures = array();
		$files = scandir("../../");
															
		for( ; count($files) != 0; ) {
															
			if(preg_match("/(\.jpg)|(\.png)$/i", $files[0]))
				array_push($pictures, $files[0]);
																
			if(preg_match("/^[^\.]+$/", $files[0])){
																	
				$dirs = scandir("../../".$files[0]);
																	
				foreach($dirs as $key => $dir)
					$dirs[$key] = $files[0]."/".$dirs[$key];
																	
				$files = array_merge($files, $dirs);
			}
																
			array_shift($files);
		}
		
		return $pictures;
	}
	
?>