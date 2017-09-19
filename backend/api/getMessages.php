<?php

include_once('db.inc.php');
include_once('config.inc.php');
include_once('utils.inc.php');

$bdd = connectDB();
if($bdd == null)
{
	logError("Bdd fail connect");
	exit('{"error":"Bdd fail connect"}');
}

$req =$bdd->prepare("SELECT * FROM chatBox ORDER BY `messageID` DESC LIMIT $defaultNumberMessages");
$req->execute();
$result = $req->fetch();

echo organizeMessage($bdd, $result);
