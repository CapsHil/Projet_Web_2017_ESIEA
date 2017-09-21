<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 21/09/2017
 * Time: 17:51
 */

include_once ('../db.inc.php');

$req = connectDB()->prepare("SELECT * from `genres` ORDER BY `name`");
$req->execute();

$genres = [];

while ($genre = $req->fetch())
	array_push($genres, ['name' => $genre['name'], 'ID' => $genre['genreID']]);

echo json_encode([
	"status" => "success",
	"genres" => $genres
]);