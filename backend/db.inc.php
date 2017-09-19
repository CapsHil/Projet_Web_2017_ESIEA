<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 12/09/2017
 * Time: 14:22
 */

include_once('config.inc.php');
include_once('utils.inc.php');

function connectDB()
{
    try
    {
        $bdd = new PDO($dbName, $dbUserName, $dbPassword);
    }
    catch (Exception $bdd)
    {
        logError('Error : ' . $bdd->getMessage());
        die('internal_error');
    }
    return $bdd;
}

/*
 *  Insertion in the database
 */

function registerGenre($genreName = "")
{
    if(empty($genreName))
        return 0;

    $bdd = connectDB();
    if($bdd == null)
        return 0;

    $req = $bdd->prepare('INSERT INTO `genre`(`name`) VALUES(?1)');
    $out = $req->execute(array('?1' => strtolower($genreName)));
    $req->closeCursor();

    if($out)
        return $bdd->lastInsertId();

    $req = $bdd->prepare('SELECT `genreID` FROM `genre` WHERE `name` = ?1');
    $req->execute(array('?1' => strtolower($genreName)));
    $data = $req->fetch();
	$req->closeCursor();

    return $data['genreID'];
}

function hasGenre($genreID = 0)
{
    if(!is_numeric($genreID) || $genreID == 0)
        return false;

    $bdd = connectDB();
    if($bdd == null)
        return false;

    $req = $bdd->prepare('SELECT COUNT() FROM `genre` WHERE `genreID` = ?1');
    $req->execute(array('?1' => $genreID));
    $data = $req->fetch();
    $req->closeCursor();

    return $data != 0;
}

function getGenreForID($songID, $bdd = null)
{
	if($bdd == null)
	{
		$bdd = connectDB();
		if($bdd == null)
			return false;
	}

	$req = $bdd->prepare('SELECT `genreID` FROM `music` WHERE `ID` = ?1');
	$req->execute(array('?1' => $songID));
	$data = $req->fetch();
	$req->closeCursor();

	return $data['genreID'];

}

function registerSong($filename = "", $artistName = "", $trackName = "", $genreID = 0)
{
    if(empty($filename) || empty($artistName) || empty($trackName) || empty($genreID))
        return false;

	$bdd = connectDB();
	if($bdd == null)
		return false;

	$req = $bdd->prepare('INSERT INTO `music` (`genreID`, `filename`, `trackName`, `artistName`) 
														VALUES(?genre, ?filename, ?trackName, ?artistName)');
	$out = $req->execute(array('?genre' => $genreID, '?filename' => $filename, '?trackName' => $trackName, '?artistName' => $artistName));
	$req->closeCursor();

    return $out == true;
}

function getRandomSong()
{
	$bdd = connectDB();
	if($bdd == null)
		return false;

	//We're trying to get a random ID from the database
	//SORT RAND() LIMIT 1 would work but may become a bottleneck later on
	//http://jan.kneschke.de/projects/mysql/order-by-rand/ describes the alternative method used there
	//For the sake of complexity, we don't try to get a clean distribution, meaning that deleted song will
	//      increase the odds that the one after it get selected. If too big of a problem, those IDs aren't
	//      used elsewhere and can be recomputed whenever necessary, as long as the application is down.

	$req = $bdd->prepare('SELECT `ID`
		FROM `music` AS r1 JOIN
		   (SELECT (RAND() *
		                 (SELECT MAX(ID)
		                    FROM `music`)) AS ID)
		    AS r2
		WHERE r1.ID >= r2.ID
		ORDER BY r1.ID ASC LIMIT 1;');

	if($req->execute())
	{
		$data = $req->fetch();
		$output = $data['ID'];
	}
	else
		$output = -1;

	$req->closeCursor();
	return $output;
}

function getNbSongs()
{
	$bdd = connectDB();
	if($bdd == null)
		return false;

	$req = $bdd->prepare('SELECT COUNT() FROM `music`');
	$req->execute();
	$data = $req->fetch();
	$req->closeCursor();

	return $data;
}

function getCloseRelativeSong($songID, $maxReturn)
{
	$bdd = connectDB();
	if($bdd == null)
		return false;

	$genre = getGenreForID($songID);

	$req = $bdd->prepare('SELECT `ID` FROM `music` WHERE `genreID` == ?genre AND `ID` != ?songID');
	$req->execute(array());
	$data = $req->fetch();
	$req->closeCursor();

	return $data;

}