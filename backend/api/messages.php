<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 23/10/2017
 * Time: 16:12
 */

include_once('../db.inc.php');
include_once('../config.inc.php');
include_once('../utils.inc.php');

function getMessages($input)
{
	if(is_int($input['nbSuggestions']))
		$nbMessages = $input['nbSuggestions'];
	else
		$nbMessages = $GLOBALS['defaultNbMessages'];

	$wantOnlyNewMessages = is_int($input['lastMaxId']);

	$bdd = connectDB();

	if($wantOnlyNewMessages)
	{
		$req =$bdd->prepare("SELECT * FROM chatBox WHERE `messageID` > ?lastMaxID ORDER BY `messageID` DESC LIMIT $nbMessages");
		$req->execute(array('?lastMaxId' => $input['lastMaxId']));
	}
	else
	{
		$req = $bdd->prepare("SELECT * FROM chatBox ORDER BY `messageID` DESC LIMIT $nbMessages");
		$req->execute();
	}

	$result = $req->fetch();

	echo organizeMessage($bdd, $result);

	$req->closeCursor();
}

function sendMessage($input)
{
	if(empty($input['message']))
		return;

	if(!is_int($input['userID']))
	{
		logError('Invalid user ID (' . $input['userID'] . ') provided while trying to send a message: ' . $input['message']);
		exit('{"status":"error","error":"invalid user ID"}');
	}

	$userID = $input['userID'];
	if(!hasUserID($userID))
	{
		logError('Unknown user ID (' . $input['userID'] . ') provided while trying to send a message: ' . $input['message']);
		exit('{"status":"error","error":"unknown user ID"}');
	}

	insertMessageIntoDB($userID, $input['message']);
	exit('{"status":"success"}');
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'),true);

switch ($method)
{
	case 'GET':
	{
		getMessages($input);
		break;
	}
	case 'POST':
	{
		sendMessage($input);
		break;
	}
}