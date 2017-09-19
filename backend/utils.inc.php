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