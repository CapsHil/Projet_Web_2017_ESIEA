<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 12/09/2017
 * Time: 14:27
 */

function returnHeader()
{
	error_reporting(E_ERROR | E_PARSE);
	
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods : GET,POST,PUT,DELETE,OPTIONS');
	header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Origin, Access-Control-Allow-Methods, Authorization, X-Requested-With');
}

function logError($log=null)
{
    if($log !== null)
    {
        if($file = fopen('backend.log', 'a+'))
        {
            if(fprintf($file, '"'.date('H:i - d/M/Y - ').'","'.$_SERVER['REMOTE_ADDR'].'","'.$log."\"\n"))
            {
                fclose($file);
                return $log;
            }
        }
    }
    return false;
}

function organizeMessage($bdd, $result)
{
	$messages = array();
	$lastMessageID = 0;

	if($bdd == null)
		$bdd = connectDB();
	
	//The DB access isn't hidden in a dedicated function so we can reuse more efficiently the request.
	//Ideally, we would also cache the result as the chatbox probably only has a handful of active users.

	while($row = $result->fetch())
	{
		if($row['messageID'] > $lastMessageID)
			$lastMessageID = $row['messageID'];

		$messages[] = array(
			'messageText' => $row['messageText'],
			'user' => $row['userName'],
			'time' => $row['time']
		);
	}

	$req->closeCursor();

	if(!empty($messages))
	{
		$chatBox = array(
			'status' => 'success',
			'lastMessage' => $lastMessageID,
			'messages' => array_reverse($messages)
		);
	}
	else
	{
		$chatBox = array(
			'status' => 'error',
			'error' => 'no new message'
		);
	}

	return json_encode($chatBox);
}
