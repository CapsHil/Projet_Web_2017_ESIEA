<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 12/09/2017
 * Time: 14:27
 */

function logError($log=null)
{
    if($log !== null)
    {
        if($file = fopen('../log/security.log', 'a+'))
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
    
    if (length($result) > 0)
    {
        $lastMessageID = $result[0]['messageID']
        $req = $bdd->prepare('SELECT name FROM user WHERE `ID` = ?1');

        foreach ($result as $row) 
        {
            $req->execute(array('?1' => $row['userID']));
            $messages[] = array(
                'messageText' => $row["messageText"],
                'user' => ($req2->fetch())['name'],
                'time' => $row['time']
                )
        }
        $req->closeCursor();
    }

    $chatBox = array(
        "lastMessage" => $lastMessageID,
        "messages" => array_reverse($messages)
        );

    return json_encode($chatBox);
}