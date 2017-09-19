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

    return $data;
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