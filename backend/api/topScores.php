<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 21/09/2017
 * Time: 18:40
 */

include_once ('../db.inc.php');

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'),true);

switch ($method)
{
	case 'GET':
	{
		if(is_int($input['nbResults']))
			$nbResults = $input['nbResults'];
		else
			$nbResults = $defaultNbTopScores;

		echo json_encode([
			'status' => 'success',
			'scores' => getTopScores($nbResults)
		]);
		break;
	}
	case 'POST':
	{
		if(empty($input['strike']) || !is_numeric($input['strike']) || empty($input['name']))
		{
			exit('{"status":"error", "error": "invalid request"}');
		}

		commitStrike($input['name'], $input['strike']);
		break;
	}
}
