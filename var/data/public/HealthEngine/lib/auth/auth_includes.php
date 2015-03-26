<?php
	
	//require_once "webroot/lib/HE_global_includes.php";
	
	require_once "/var/data/public/HealthEngine/lib/HE_globals.php";
	require_once "/var/data/public/HealthEngine/lib/HE_global_includes.php";
	$llogger = & $GLOBALS["HE_LOGGER"];
	
	$llogger->logme(3, "Starting auth_includes.php");
	
	$llogger->logme(3, "including auth.inc");
	require_once "/var/data/public/library/auth.inc";
	
	$llogger->logme(3, "including login_operations.php");
	require_once "/var/data/public/library/authentication/login_operations.php";
	
	$llogger->logme(3, "including password_change.php");
	require_once "/var/data/public/library/authentication/password_change.php";
	
	$llogger->logme(3, "including password_hashing.php");
	require_once "/var/data/public/library/authentication/password_hashing.php";
	
	$llogger->logme(3, "including privDB.php");
	require_once "/var/data/public/library/authentication/privDB.php";
	
	$llogger->logme(3, "including access_auth.php");
	require_once "./access_auth.php";
	
	$llogger->logme(3, "including auth.php");
	require_once "./auth.php";
	
	
?>
