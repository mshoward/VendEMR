<?php
	require_once "webroot/HealthEngine/lib/HE_globals.php";
	require_once "webroot/HealthEngine/lib/debugging/logger.php";
	$GLOBALS["HE_LOGGER"] = new logger();
	$llogger = & $GLOBALS["HE_LOGGER"];

	$llogger->logme(3, "Including webroot/library/globals.inc.php");
	require_once "webroot/library/globals.inc.php";
	$llogger->logme(3, "Including webroot/interface/globals.php");
	require_once "webroot/interface/globals.php";
	$llogger->logme(3, "End HE_global_includes.php");
	
?>
