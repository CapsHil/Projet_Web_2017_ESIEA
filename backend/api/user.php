<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 21/09/2017
 * Time: 18:21
 */

include_once ('../db.inc.php');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'),true);

if(empty($input['name']) || empty($input['password']))
	exit('{"status":"error", "error":"missing argument"}');

switch ($method)
{
	case 'DELETE':
	{
		$result = validateUserPassword($input['name'], $input['password']);

		if($result !== false)
		{
			deleteUser($result);
			echo '{"status":"success"}';
		}
		else
			echo '{"status":"error", "error":"invalid name or password"}';

		break;
	}
	case 'POST':
	{
		if(empty($input['email']))
			exit('{"status":"error", "error":"missing argument"}');

		if(createUser($input['name'], $input['email'], $input['password']))
			echo '{"status":"success"}';
		else
			echo '{"status":"error", "error":"could not create user account"}';

		break;
	}

	case 'GET':
	{
		$result = validateUserPassword($input['name'], $input['password']);

		if($result !== false)
			echo '{"status":"success", "userID": ' . $result . '}';
		else
			echo '{"status":"error", "error":"invalid name or password"}';
	}
}
