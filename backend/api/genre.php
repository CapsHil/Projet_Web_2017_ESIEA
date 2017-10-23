<?php
include_once("../db.inc.php");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'),true);

switch ($method)
{
	case 'GET':
	{
		$req = connectDB()->prepare("SELECT * from `genres` ORDER BY `name`");
		$req->execute();

		$genres = [];

		while ($genre = $req->fetch())
			array_push($genres, ['name' => $genre['name'], 'ID' => $genre['genreID']]);

		echo json_encode([
			"status" => "success",
			"genres" => $genres
		]);
		break;
	}
	case 'POST':
	{
		include_once("../utils.inc.php");

		if($input['name'] != '')
		{
			$output = registerGenre($input['name']);
		}
		else
		{
			logError("genre empty");
			$output = 0;
		}

		if($output == 0)
			echo '{"status":"error","error":"Could not create genre"}';
		else
			echo '{"status":"success","genreID":' . $output . '}';
		break;
	}
}