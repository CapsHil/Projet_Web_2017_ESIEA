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
        $bdd = new PDO(dbName, dbUserName, dbPassword);
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

function hasGenre($genreID = 0)
{
    if(!is_numeric($genreID) || $genreID == 0)
        return false;

    $bdd = connectDB();
    $req = $bdd->prepare('SELECT COUNT(*) FROM `genre` WHERE `genreID` = :1');
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

function getRandomSongs($bdd = null, $nbSongs = 1)
{
	if(!is_integer($nbSongs) || $nbSongs < 1)
		return false;

	if($bdd == null)
		$bdd = connectDB();

	//We're trying to get a random ID from the database
	//SORT RAND() LIMIT 1 would work but may become a bottleneck later on
	//http://jan.kneschke.de/projects/mysql/order-by-rand/ describes the alternative method used there
	//For the sake of complexity, we don't try to get a clean distribution, meaning that deleted song will
	//      increase the odds that the one after it get selected. If too big of a problem, those IDs aren't
	//      used elsewhere and can be recomputed whenever necessary, as long as the application is down.

	$req = $bdd->prepare('SELECT r1.`ID`
		FROM `music` AS r1 JOIN
		   (SELECT (RAND() *
		                 (SELECT MAX(ID)
		                    FROM `music`)) AS ID)
		    AS r2
		WHERE r1.ID >= r2.ID
		ORDER BY r1.ID ASC LIMIT ' . $nbSongs . ';');

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

function getNbSongs($bdd = null)
{
	if($bdd == null)
		$bdd = connectDB();

	$req = $bdd->prepare('SELECT COUNT() FROM `music`');
	$req->execute();
	$data = $req->fetch();
	$req->closeCursor();

	return $data;
}

function getCloseRelativeSong($songID, $bdd = null, $maxReturn = 0)
{
	if($bdd == null)
		$bdd = connectDB();

	$genre = getGenreForID($songID);

	if(empty($maxReturn))
	{
		$req = $bdd->prepare('SELECT `ID` FROM `music` WHERE `genreID` = :1 AND `ID` != :2 ORDER BY RAND()');
		$req->execute(array(':1' => $genre, ':2' => $songID));
	}
	else
	{
		$req = $bdd->prepare('SELECT `ID` FROM `music` WHERE `genreID` = :1 AND `ID` != :2 ORDER BY RAND() LIMIT :3');
		$req->execute(array(':1' => $genre, ':2' => $songID, ':3' => $maxReturn));
	}
	$data = $req->fetch();
	$req->closeCursor();

	$output = array();

	foreach ($data as $entry)
	{
		array_push($output, $entry['ID']);
	}

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

function insertMessageIntoDB($userID, $message)
{
	$req = connectDB()->prepare("INSERT INTO `chatbox`(`messageText`, `userID`) VALUES (:1, :2)");
	$output = $req->execute([
		':1' => $message,
		':2' => $userID
	]);

	return $output;
}

//User management

//The password is already hashed using password_hash
function createUser($name, $email, $password)
{
	$hashedPassword = hashPasswordForUser($password);
	if($hashedPassword === false)
		return false;

	$req = connectDB()->prepare("INSERT INTO `user`(`name`, `password`, `email`) VALUES (:1, :2, :3)");
	$output = $req->execute([
		':1' => $name,
		':2' => $hashedPassword,
		':3' => $email
		]);

	$req->closeCursor();

	return $output;
}

function validateUserPassword($name, $password)
{
	$req = connectDB()->prepare("SELECT `password`, `ID` FROM `user` WHERE `name` = :1");

	if($req->execute([':1' => $name]))
	{
		$data = $req->fetch();

		if(password_verify($password, $data['password']))
			$output = $data['ID'];
		else
			$output = false;
	}
	else
		$output = false;

	$req->closeCursor();

	return $output;
}

function getUserIDFromName($name)
{
	$req = connectDB()->prepare('SELECT `ID` FROM `user` WHERE `name` = :1');
	$output = $req->execute([':1' => $name]);

	if($output !== false)
	{
		$data = $req->fetch();
		$output = $data['ID'];
	}

	$req->closeCursor();

	return $output;
}

function hasUserID($userID, $bdd = null)
{
	if($bdd == null)
		$bdd = connectDB();

	$req = $bdd->prepare('SELECT COUNT(`ID`) FROM `user` WHERE `ID` = :1');
	$req->execute([':1' => $userID]);
	$count = $req->fetch();
	$output = $count[0] == 1;
	$req->closeCursor();

	return $output;
}

function deleteUser($userID)
{
	$bdd = connectDB();

	$req = $bdd->prepare('DELETE FROM `chatbox` WHERE `userID` = :1;
									DELETE FROM `highScore` WHERE `userID` = :1; 
									DELETE FROM `user` WHERE `ID` = :1;');

	$req->execute([':1' => $userID]);
	$req->closeCursor();
}

//High scores management

function getTopScores($nbTopScores)
{
	$bdd = connectDB();
	$req = $bdd->prepare('SELECT `highScore`.`score` AS score, `user`.`name` as name 
FROM `highScore` 
INNER JOIN `user` ON `highScore`.`userID` = `user`.`ID`
ORDER BY `highScore`.`score`
LIMIT :1');

	$req->execute([':1' => $nbTopScores]);

	$counter = 1;
	$output = [];

	while ($score = $req->fetch())
		array_push($output, ['rank' => $counter++, 'user' => $score['name'], 'score' => $score['score']]);

	return $output;
}

function increaseCurrentStrike($userID, $bdd)
{
	if($bdd == null)
		$bdd = connectDB();

	$req = $bdd->prepare('UPDATE `user` SET `currentStrike` = `currentStrike` + 1 WHERE `ID` = :1');
	$req->execute([':1' => $userID]);
	$req->closeCursor();
}

function commitStrike($userID, $bdd)
{
	if($bdd == null)
		$bdd = connectDB();

	$req = $bdd->prepare('SELECT `currentStrike` FROM `user` WHERE `ID` = :1');
	$req->execute([':1' => $userID]);
	$data = $req->fetch();
	$currentStrike = $data['currentStrike'];
	$req->closeCursor();

	$req = $bdd->prepare('UPDATE `user` SET `currentStrike` = 0 WHERE `ID` = :1');
	$req->execute([':1' => $userID]);
	$req->closeCursor();

	$req = $bdd->prepare('UPDATE `highScore` SET `score` = :1 WHERE `userID` = :2');
	$req->execute([':1' => $currentStrike, ':2' => $userID]);
	$req->closeCursor();
}