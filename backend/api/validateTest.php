<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 21/09/2017
 * Time: 18:20
 */

if(!is_int($_REQUEST['userID']) || !is_int($_REQUEST['songID']) || !is_int($_REQUEST['answer']))
	exit('{"status":"error", "error": "invalid arguments"}');

include_once ('../db.inc.php');

$bdd = connectDB();

if(!hasUserID($_REQUEST['userID'], $bdd))
	exit('{"status":"error", "error": "invalid user"}');

if(!hasSong($_REQUEST['songID'], $bdd) || !hasSong($_REQUEST['answer'], $bdd))
	exit('{"status":"error", "error": "invalid song"}');

if($_REQUEST['songID'] == $_REQUEST['answer'])
{
	increaseCurrentStrike($_REQUEST['userID'], $bdd);
	echo '{"status":"success", "correct":true}';
}
else
{
	commitStrike($_REQUEST['userID'], $bdd);
	echo '{"status":"success", "correct":false}';
}