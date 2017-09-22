<?php

include_once('../db.inc.php');
include_once('../config.inc.php');
include_once('../utils.inc.php');

if(is_int($_REQUEST['nbSuggestions']))
	$nbMessages = $_REQUEST['nbSuggestions'];
else
	$nbMessages = $defaultNbMessages;

$bdd = connectDB();
$req = $bdd->prepare("SELECT * FROM chatBox ORDER BY `messageID` DESC LIMIT $nbMessages");
$req->execute();

echo organizeMessage($bdd, $req->fetch());

$req->closeCursor();
