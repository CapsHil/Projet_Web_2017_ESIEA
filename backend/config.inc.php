<?php
/**
 * Created by PhpStorm.
 * User: Taiki
 * Date: 12/09/2017
 * Time: 14:23
 */

define('dbUserName', "user");
define('dbPassword', "password");
define('dbName', 'mysql: host=mysql;dbname=sirius');

$defaultNbSuggestions = 4;
$defaultNbMessages = 200;
$defaultNbTopScores = 20;

//Path to return for the frontend to be able to serve the file
$publicMusicDirectory = 'music/';

//Relative directory from ~/backend/api/
//Current setup point to directory ~/music/
$relativeMusicDirectory = '../../' . $publicMusicDirectory;
