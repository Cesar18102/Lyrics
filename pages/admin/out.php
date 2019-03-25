<?php

	setcookie("admin_auth", "", -3600, "/");
	$_COOKIE["admin_auth"] = "";
	unset($_COOKIE["admin_auth"]);
	
	Header("Location: ".(isset($_POST['redirect']) && $_POST['redirect'] != ""? $_POST['redirect'] : $_SERVER['DOCUMENT_ROOT']));
?>