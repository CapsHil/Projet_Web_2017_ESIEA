<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 12/09/2017
 * Time: 14:22
 */

include_once('config.inc.php');
include_once('utils.inc.php');

returnHeader();

function connectDB()
{
	try
	{
		$bdd = new PDO(dbName, dbUserName, dbPassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
	}
	catch (Exception $bdd)
	{
		logError('Error : ' . $bdd->getMessage());
		die('{"status":"error","error":"Could not connect to database"}');
	}

	if($bdd == null)
		die('{"status":"error","error":"Could not connect to database"}');

	return $bdd;
}

/*
 *  Insertion in the database
 */

//Genre management

function registerGenre($genreName = "")
{
	if(empty($genreName))
		return 0;

	$bdd = connectDB();
	$req = $bdd->prepare('INSERT INTO `genre`(`name`) VALUES(:1)');
	$out = $req->execute(array(':1' => strtolower($genreName)));

	$req->closeCursor();

	if($out)
		return $bdd->lastInsertId();

	$req = $bdd->prepare('SELECT `genreID` FROM `genre` WHERE `name` = :1');
	$req->execute(array(':1' => strtolower($genreName)));
	$data = $req->fetch();
	$req->closeCursor();

	return $data['genreID'];
}

function hasGenre($genreID = 0, $bdd = null)
{
	if(!is_numeric($genreID) || $genreID == 0)
		return false;

	if($bdd == null)
		$bdd = connectDB();
	
	$req = $bdd->prepare('SELECT COUNT(*) FROM `genre` WHERE `genreID` = :1');
	$req->execute(array(':1' => $genreID));
	$data = $req->fetch();
	$req->closeCursor();

	return $data[0] != 0;
}

function validateGenre($genreID = 0)
{
	if(!is_numeric($genreID) || $genreID == 0)
		return false;

	$bdd = connectDB();

	if(!hasGenre($genreID, $bdd))
		return false;	

	$req = $bdd->prepare('SELECT COUNT(*) FROM `music` WHERE `genreID` = :1');
	$req->execute(array(':1' => $genreID));
	$data = $req->fetch();
	$req->closeCursor();

	return $data[0] != 0;
}

function getGenreForID($songID, $bdd = null)
{
	if($bdd == null)
		$bdd = connectDB();

	$req = $bdd->prepare('SELECT `genreID` FROM `music` WHERE `ID` = :1');
	$req->execute(array(':1' => $songID));
	$data = $req->fetch();
	$req->closeCursor();

	return $data['genreID'];
}

//Song management

function registerSong($filename = "", $artistName = "", $trackName = "", $genreID = 0)
{
	if(empty($filename) || empty($artistName) || empty($trackName) || empty($genreID))
		return false;

	$req = connectDB()->prepare('INSERT INTO `music` (`genreID`, `filename`, `trackName`, `artistName`) 
														VALUES(:1, :2, :3, :4)');
	$out = $req->execute(array(':1' => $genreID, ':2' => $filename, ':3' => $trackName, ':4' => $artistName));
	$req->closeCursor();

	return $out == true;
}

function getRandomSongs($bdd = null, $nbSongs = 1, $genreArray = [])
{
	if(!is_integer($nbSongs) || $nbSongs < 1)
		return false;

	if($bdd == null)
		$bdd = connectDB();

	if(is_array($genreArray) && !empty($genreArray))
	{
		$genreString = '';
		foreach ($genreArray as $genre)
		{
			$genreString .= ", '" . $genre . "'";
		}

		$genreString = substr($genreString, 2);	//Remove the first ', '

		$req = $bdd->prepare('SELECT `ID` FROM `music`
			WHERE `genreID` IN(' . $genreString . ')
			ORDER BY RAND() LIMIT ' . $nbSongs . ';');
	}
	else
	{
		$req = $bdd->prepare('SELECT `ID` FROM `music` 
			ORDER BY RAND() LIMIT ' . $nbSongs . ';');
	}

	$output = [];

	if($req->execute())
	{
		while($entry = $req->fetch())
			array_push($output, $entry['ID']);
	}

	$req->closeCursor();
	return $output;
}

function getNbSongs($bdd = null)
{
	if($bdd == null)
		$bdd = connectDB();

	$req = $bdd->prepare('SELECT COUNT() FROM `music`');
	$req->execute();
	$data = $req->fetch();
	$req->closeCursor();

	return $data[0];
}

function getCloseRelativeSong($songID, $bdd = null, $maxReturn = 0)
{
	if($bdd == null)
		$bdd = connectDB();

	$genre = getGenreForID($songID);

	$sql = 'SELECT `ID` FROM `music` WHERE `genreID` = :1 AND `ID` != :2 ORDER BY RAND()';

	if(!empty($maxReturn) && is_numeric($maxReturn))
	{
		$sql .= ' LIMIT ' . (int) $maxReturn;
	}

	$req = $bdd->prepare($sql);
	$req->execute(array(':1' => $genre, ':2' => $songID));

	$output = array();

	while($data = $req->fetch())
		array_push($output, $data['ID']);

	$req->closeCursor();
	return $output;
}

function extractDataForSongs($songIDs, $bdd = null)
{
	if(!is_array($songIDs) || count($songIDs) == 0)
		return array();

	if($bdd == null)
		$bdd = connectDB();

	$req = $bdd->prepare('SELECT `ID`, `trackName`, `artistName` FROM `music` WHERE `ID` = :1');

	$output = array();

	foreach ($songIDs as $song)
	{
		$req->execute(array(':1' => $song));
		$data = $req->fetch();

		array_push($output, array(  "songID" => $data['ID'],
									"trackName" => $data['trackName'],
									"artistName" => $data['artistName']));
	}

	$req->closeCursor();
	return $output;
}

function getFileName($songID, $bdd = null)
{
	if($bdd == null)
		$bdd = connectDB();

	$req = $bdd->prepare('SELECT `filename` FROM `music` WHERE `ID` = :1');
	$req->execute(array(':1' => $songID));
	$data = $req->fetch();
	$req->closeCursor();

	return $data['filename'];
}

function hasSong($songID, $bdd = null)
{
	if($bdd == null)
		$bdd = connectDB();

	$req = $bdd->prepare('SELECT COUNT(*) FROM `music` WHERE `ID` = :1');
	$req->execute([':1' => $songID]);
	$output = $req->fetchColumn() == 1;
	$req->closeCursor();

	return $output;
}

//Chat management

function insertMessageIntoDB($userName, $message)
{
	$req = connectDB()->prepare("INSERT INTO `chatbox`(`messageText`, `userName`) VALUES (:1, :2)");
	$output = $req->execute([
		':1' => $message,
		':2' => $userName
	]);

	return $output;
}

//High scores management

function getTopScores($nbTopScores)
{
	$bdd = connectDB();
	$req = $bdd->prepare('SELECT `score`, `userName` FROM `highScore` ORDER BY `score` LIMIT' . ((int) $nbTopScores));
	$req->execute();

	$counter = 1;
	$output = [];

	while ($score = $req->fetch())
		array_push($output, ['rank' => $counter++, 'user' => $score['userName'], 'score' => $score['score']]);

	return $output;
}

function commitStrike($userName, $strike)
{
	$bdd = connectDB();

	$req = $bdd->prepare('SELECT `score` FROM `highScore` WHERE `userName` = :1');
	$req->execute([':1' => $userName]);
	$data = $req->fetch();
	$req->closeCursor();

	if(empty($data))
		$req = $bdd->prepare('INSERT INTO `highScore`(`userName`, `score`) VALUES (:2, :1)');

	else if($data['score'] < $strike)
		$req = $bdd->prepare('UPDATE `highScore` SET `score` = :1 WHERE `userName` = :2');

	else
		return;

	$req->execute([':1' => $strike, ':2' => $userName]);
	$req->closeCursor();
}