<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 19/09/2017
 * Time: 09:27
 */

	$nbEntries = getNbSongs();

	if(isset($_REQUEST['nbSuggestions']) && is_numeric($_REQUEST['nbSuggestions']))
		$nbSuggestions = min($nbEntries, $_REQUEST['nbSuggestions']);

	else
		$nbSuggestions = 4;


	$question = getRandomSong();
	if($question == -1)
		exit('{"error":"could not generate a song"}');


	//The list could contains deleted items...
	if(isset($_REQUEST['excludeRecentlyTried']))
	{
		$rawExclusion = json_decode($_REQUEST['excludeRecentlyTried']);

		if($rawExclusion != null && is_array($rawExclusion))
		{

		}
	}