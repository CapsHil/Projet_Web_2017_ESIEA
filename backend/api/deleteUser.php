<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 21/09/2017
 * Time: 18:31
 */

if(empty($_REQUEST['name']) || empty($_REQUEST['password']))
	exit('{"status":"error", "error":"missing argument"}');

include_once ('../db.inc.php');

$result = validateUserPassword($_REQUEST['name'], $_REQUEST['password']);
if($result !== false)
{
	deleteUser($result);
	echo '{"status":"success"}';
}
else
	echo '{"status":"error", "error":"invalid name or password"}';