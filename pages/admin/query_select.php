<?php

	if(isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true" && 
	   isset($_POST['query']) && $_POST['query'] != "") {
		
		include "../../scripts/php/DB_Request.php";
		$db_link = Connect();
		$resp = Request($db_link, $_POST['query']);
		
		$response = "{";
		
		while($cortage = mysqli_fetch_array($resp, MYSQLI_ASSOC))
			foreach($cortage as $key => $value) 
				$response .= '"'.$key.'" : '.$value.', ';
				
		echo substr($response, 0, strlen($response) - 2)."}";
	}
?>