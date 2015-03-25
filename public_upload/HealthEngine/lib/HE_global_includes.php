<?php
	require_once "/var/data/public/HealthEngine/lib/HE_globals.php";
	require_once "/var/data/public/HealthEngine/lib/debugging/logger.php";
	// $GLOBALS["HE_LOGGER"] = new logger();
	$llogger = new logger();
	echo "this far<br>";
	$llogger->shout(3,"testing the shout");
	$llogger->logme(3, "Including webroot/library/globals.inc.php");
	require_once "/var/data/public/library/globals.inc.php";
	$llogger->logme(3, "Including webroot/interface/globals.php");
	require_once "/var/data/public/interface/globals.php";
	$llogger->logme(3, "End HE_global_includes.php");
	
?>
