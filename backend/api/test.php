<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 19/09/2017
 * Time: 09:27
 */

	include_once ('../db.inc.php');

	function getTest($input)
	{
		$bdd = connectDB();
		echo 'coucou';

		$nbEntries = getNbSongs($bdd);

		//Compute the number of alternative suggestions to provide
		if(isset($input['nbSuggestions']) && is_numeric($input['nbSuggestions']))
			$nbSuggestions = min($nbEntries, $input['nbSuggestions']);

		else
			$nbSuggestions = $GLOBALS['defaultNbSuggestions'];

		//The list could contains deleted items...
		$hasExclusion = false;
		if(isset($input['excludeRecentlyTried']))
		{
			$exclusion = json_decode($input['excludeRecentlyTried']);

			if($exclusion != null && is_array($exclusion))
				$hasExclusion = true;
		}
		else
			$exclusion = [];

		//Get the ID of the song that will have to be guessed
		$question = getRandomSongs($bdd);
		if($question == -1)
			exit('{"status":"error","error":"could not generate a song"}');

		$output = array($question);

		//Get related songs to populate the suggestions
		$outputLength = 1;
		$suggestions = getCloseRelativeSong($question, $bdd, $nbSuggestions - 1 + ($hasExclusion ? count($exclusion) : 0));

		while($outputLength < $nbSuggestions)
		{
			foreach ($suggestions as $relative)
			{
				if(!$hasExclusion || !in_array($relative, $exclusion))
				{
					array_push($output, $relative);
					$outputLength += 1;

					if($outputLength != $nbSuggestions)
						break;
				}
			}

			//If we don't have enough related songs, so we get a few more random one.
			//We may have to do that multiple times depending of the exclusion list
			if($outputLength < $nbSuggestions)
			{
				$suggestions = getRandomSongs($bdd, $nbSuggestions - $outputLength);
			}
		}

		shuffle($output);

		$processedOutput = extractDataForSongs($output, $bdd);

		if(empty($processedOutput))
			exit('{"status":"error","error":"could not generate output"}');

		$finalOutput = array(
			'status' => 'success',
			'songID' => $question,
			'filename' => $GLOBALS['publicMusicDirectory'] . getFileName($question, $bdd),
			'suggestions' => $processedOutput);

		echo json_encode($finalOutput);
	}

	function validateTest($input)
	{
		if(!is_int($input['userID']) || !is_int($input['songID']) || !is_int($input['answer']))
			exit('{"status":"error", "error": "invalid arguments"}');

		include_once ('../db.inc.php');

		$bdd = connectDB();

		if(!hasUserID($input['userID'], $bdd))
			exit('{"status":"error", "error": "invalid user"}');

		if(!hasSong($input['songID'], $bdd) || !hasSong($input['answer'], $bdd))
			exit('{"status":"error", "error": "invalid song"}');

		if($input['songID'] == $input['answer'])
		{
			increaseCurrentStrike($input['userID'], $bdd);
			echo '{"status":"success", "correct":true}';
		}
		else
		{
			commitStrike($input['userID'], $bdd);
			echo '{"status":"success", "correct":false}';
		}
	}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'),true);

switch ($method)
{
	case 'GET':
	{
		getTest($input);
		break;
	}
	case 'POST':
	{
		validateTest($input);
		break;
	}
}
