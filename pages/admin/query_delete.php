<?php

	if(isset($_COOKIE["admin_auth"]) && $_COOKIE["admin_auth"] == "true" && 
	   isset($_POST['redirect']) && $_POST['redirect'] != "" && 
	   isset($_POST['table']) && $_POST['table'] != "" && 
	   isset($_POST['id']) && $_POST['id'] != "") {
		
		$redirect = $_POST['redirect'];
		$QUERY = "DELETE FROM ".$_POST['table']." WHERE id = ".$_POST['id'];
		
		include "../../scripts/php/DB_Request.php";
		$db_link = Connect();
		Request($db_link, $QUERY);
		
		Header("Location: ".$redirect);
	}
?>