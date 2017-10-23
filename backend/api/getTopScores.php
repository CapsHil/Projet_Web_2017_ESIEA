<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 21/09/2017
 * Time: 18:40
 */

if(is_int($_REQUEST['nbResults']))
	$nbResults = $_REQUEST['nbResults'];
else
	$nbResults = $defaultNbTopScores;

include_once ('../db.inc.php');

echo json_encode([
	'status' => 'success',
	'scores' => getTopScores($nbResults)
]);