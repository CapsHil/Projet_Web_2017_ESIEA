<?php
include_once('../db.inc.php');
include_once('../config.inc.php');
include_once('../utils.inc.php');

if(!is_int($_REQUEST['lastMaxId']))
{
	logError("invalid Value" . $_REQUEST['lastMaxId']);
	exit('{"status":"error","error":"invalid previous message ID"}');
}

if(is_int($_REQUEST['nbSuggestions']))
	$nbMessages = $_REQUEST['nbSuggestions'];
else
	$nbMessages = $defaultNbMessages;

$bdd = connectDB();
$req =$bdd->prepare("SELECT * FROM chatBox WHERE `messageID` > ?lastMaxID ORDER BY `messageID` DESC LIMIT $nbMessages");
$req->execute(array('?lastMaxId' => $_REQUEST['lastMaxId']));
$result = $req->fetch();

echo organizeMessage($bdd, $result);

$req->closeCursor();
