<?php
	
	if(isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true" && 
	   isset($_POST['table']) && $_POST['table'] && isset($_POST['id'])) {
		   
		include "../../scripts/php/DB_Request.php";
		$db_link = Connect();
		
		$DEL = "DELETE FROM ".$_POST['table']." WHERE id = ".$_POST['id'];
		Request($db_link, $DEL);
		
		$QUERY = "INSERT INTO ".$_POST['table'];
		
		$redirect = isset($_POST['redirect'])? $_POST['redirect'] : "";
		
		unset($_POST['redirect']);
		unset($_POST['table']);
		
		$values = "('";
		
		foreach($_POST as $key => $value)
			$values .= str_replace("'", "\'", $value)."', '";
			
		$values = substr($values, 0, strrpos($values, ',')).")";
		
		$QUERY .= " VALUES".$values;
		
		Request($db_link, $QUERY);
		
		if($redirect != "")
			Header("Location: ".$redirect);
	}
?>