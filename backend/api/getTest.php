<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 19/09/2017
 * Time: 09:27
 */

	include_once ('../db.inc.php');

	$bdd = connectDB();

	$nbEntries = getNbSongs($bdd);

	//Compute the number of alternative suggestions to provide
	if(isset($_REQUEST['nbSuggestions']) && is_numeric($_REQUEST['nbSuggestions']))
		$nbSuggestions = min($nbEntries, $_REQUEST['nbSuggestions']);

	else
		$nbSuggestions = $defaultNbSuggestions;

	//The list could contains deleted items...
	$hasExclusion = false;
	if(isset($_REQUEST['excludeRecentlyTried']))
	{
		$exclusion = json_decode($_REQUEST['excludeRecentlyTried']);

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
		'filename' => "music/" . getFileName($question, $bdd),
		'suggestions' => $processedOutput);

	echo json_encode($finalOutput);