<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 19/09/2017
 * Time: 09:27
 */

	include_once ('../db.inc.php');
	$input = json_decode(file_get_contents('php://input'),true);

	$bdd = connectDB();

	$nbEntries = getNbSongs($bdd);

	//Compute the number of alternative suggestions to provide
	if(isset($input['nbSuggestions']) && is_numeric($input['nbSuggestions']))
		$nbSuggestions = min($nbEntries, $input['nbSuggestions']);

	else
		$nbSuggestions = $defaultNbSuggestions;

	//The list could contains deleted items...
	$hasExclusion = false;
	if(isset($input['excludeRecentlyTried']))
	{
		$exclusion = $input['excludeRecentlyTried'];

		if($exclusion != null && is_array($exclusion))
			$hasExclusion = true;
	}
	else
		$exclusion = [];

	//Get the ID of the song that will have to be guessed
	$questions = getRandomSongs($bdd);
	if(empty($questions))
		exit('{"status":"error","error":"could not generate a song"}');

	$question = $questions[0];
	$output = [$question];

	//Get related songs to populate the suggestions
	$outputLength = 1;
	$suggestions = getCloseRelativeSong($question, $bdd, $nbSuggestions - 1 + ($hasExclusion ? count($exclusion) : 0));

	$tries = 0;

	while($outputLength < $nbSuggestions && $tries < 15)
	{
		foreach ($suggestions as $relative)
		{
			if((!in_array($relative, $output) || $tries >= 10) && 
				(!$hasExclusion || !in_array($relative, $exclusion) || $tries >= 5))
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
			$tries += 1;
		}
	}

	shuffle($output);

	$processedOutput = extractDataForSongs($output, $bdd);

	if(empty($processedOutput))
		exit('{"status":"error","error":"could not generate output"}');

	$finalOutput = array(
		'status' => 'success',
		'songID' => $question,
		'filename' => getFileName($question, $bdd),
		'suggestions' => $processedOutput);

	echo json_encode($finalOutput);
