<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 21/09/2017
 * Time: 18:40
 */

$input = json_decode(file_get_contents('php://input'),true);

if(is_int($input['nbResults']))
	$nbResults = $input['nbResults'];
else
	$nbResults = $defaultNbTopScores;

include_once ('../db.inc.php');

echo json_encode([
	'status' => 'success',
	'scores' => getTopScores($nbResults)
]);