<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 21/09/2017
 * Time: 18:27
 */

if(empty($_REQUEST['name']) || empty($_REQUEST['password']))
	exit('{"status":"error", "error":"missing argument"}');

include_once ('../db.inc.php');

$result = validateUserPassword($_REQUEST['name'], $_REQUEST['password']);
if($result !== false)
	echo '{"status":"success", "userID": ' . $result . '}';
else
	echo '{"status":"error", "error":"invalid name or password"}';