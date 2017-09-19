<?php
include_once('db.inc.php');
include_once('config.inc.php');
include_once('utils.inc.php');

if(!is_int($_REQUEST['lastMaxId']))
{
	logError("invalid Value" . $_REQUEST['lastMaxId']);
	exit('{"error":"invalid Value"}');
}

$bdd = connectDB();
if($bdd == null)
{
	logError("Bdd fail connect");
	exit('{"error":"Bdd fail connect"}');
}

$req =$bdd->prepare("SELECT * FROM chatBox WHERE `messageID` > ?lastMaxID ORDER BY `messageID` DESC LIMIT $defaultNumberMessages");
$req->execute('?lastMaxId' => $_REQUEST['lastMaxId']);
$result = $req->fetch();

echo organizeMessage($bdd, $result);

