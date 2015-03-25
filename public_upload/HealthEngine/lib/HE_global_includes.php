<?php
	require_once "/var/data/public/HealthEngine/lib/HE_globals.php";
	require_once "/var/data/public/HealthEngine/lib/debugging/logger.php";
	$GLOBALS["HE_LOGGER"] = new logger();
	$llogger = & $GLOBALS["HE_LOGGER"];

	$llogger->logme(3, "Including webroot/library/globals.inc.php");
	require_once "/var/data/public/library/globals.inc.php";
	$llogger->logme(3, "Including webroot/interface/globals.php");
	require_once "/var/data/public/interface/globals.php";
	$llogger->logme(3, "End HE_global_includes.php");
	
?>
