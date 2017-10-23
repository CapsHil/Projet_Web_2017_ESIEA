<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 21/09/2017
 * Time: 18:21
 */

if(empty($_REQUEST['name']) || empty($_REQUEST['email']) || empty($_REQUEST['password']))
	exit('{"status":"error", "error":"missing argument"}');

include_once ('../db.inc.php');

if(createUser($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password']))
	echo '{"status":"success"}';
else
	echo '{"status":"error", "error":"could not create user account"}';