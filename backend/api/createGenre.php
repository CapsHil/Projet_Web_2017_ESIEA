<?php
include_once("../db.inc.php");
include_once("../utils.inc.php");

if($_REQUEST['name']!="")
{
	$output = registerGenre($_REQUEST['name']);
}
else
{
	logError("genre empty");
	$output = 0;
}

return $output;
