<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 21/09/2017
 * Time: 16:29
 */

include_once('../db.inc.php');
include_once('../utils.inc.php');

if(empty($_REQUEST['message']))
	return;

if(!is_int($_REQUEST['userID']))
{
	logError('Invalid user ID (' . $_REQUEST['userID'] . ') provided while trying to send a message: ' . $_REQUEST['message']);
	exit('{"status":"error","error":"invalid user ID"}');
}

$userID = $_REQUEST['userID'];
if(!hasUserID($userID))
{
	logError('Unknown user ID (' . $_REQUEST['userID'] . ') provided while trying to send a message: ' . $_REQUEST['message']);
	exit('{"status":"error","error":"unknown user ID"}');
}

insertMessageIntoDB($userID, $_REQUEST['message']);
exit('{"status":"success"}');
