<?php

	if(isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true" && 
	   isset($_POST['redirect']) && $_POST['redirect'] != "" && 
	   isset($_POST['table']) && $_POST['table']) {
		
		$redirect = $_POST['redirect'];
		$QUERY = "INSERT INTO ".$_POST['table'];
		
		unset($_POST['redirect']);
		unset($_POST['table']);
		
		$values = "('";
		
		foreach($_POST as $key => $value)
			$values .= str_replace("'", "\'", $value)."', '";
			
		$values = substr($values, 0, strrpos($values, ',')).")";
		
		$QUERY .= " VALUES".$values;
		
		include "../../scripts/php/DB_Request.php";
		$db_link = Connect();
		Request($db_link, $QUERY);
		
		Header("Location: ".$redirect);
	}
?>