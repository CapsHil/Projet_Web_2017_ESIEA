<?php
include_once("../config.inc.php");
include_once("../db.inc.php");
include_once("../utils.inc.php");

$input = json_decode(file_get_contents('php://input'),true);

$uploadOk = true;

// Verify parameter of the song.
if(empty($input['trackName']) || empty($input['artist']) || !is_int($input['genre']))
{
    logError("empty parameter:  the name : " . $input['trackName'] . ' or the artist : ' . $input['artist'] . ' or the genre : ' . $input['genre']);
    $uploadOk = false;
}

do //Generate name file
{
    $outputFileName = bin2hex(random_bytes(8));
    $target_file = $relativeMusicDirectory . $outputFileName;

} while(file_exists($target_file));

// Check file size
if (filesize($_FILES['fileToUpload']['tmp_name']) == $_FILES['fileToUpload']['size'] && $_FILES['fileToUpload']['size'] > 500000) 
{
    logError("Upload failed, size inconsistent : " . filesize($_FILES['fileToUpload']['tmp_name']) . " != " . $_FILES['fileToUpload']['size'] . " || > 500 000");
    $uploadOk = false;
}

//Move file and register song
if ($uploadOk)
{
    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file))
    {
        logError("The file ". $_FILES['fileToUpload']['tmp_name']. " has been uploaded and renamed to $target_file.");
        if(hasGenre($input['genre']))
        {
            registerSong($outputFileName, $input['artist'], $input['trackName'], $input['genre']);
        }
    }
    else
    {
        logError("There was an error moving file ". $_FILES['fileToUpload']['tmp_name'] . " to " . $target_file);
    }
}

if($uploadOk)
	echo '{"status":"success"}';
else
	echo '{"status":"error", "error":"upload failed, or invalid file"}';