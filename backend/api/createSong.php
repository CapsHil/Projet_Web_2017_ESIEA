<?php
include_once("../db.inc.php");
include_once("../utils.inc.php");

$uploadOk = true;

// Verify paramter of the song.
if($_REQUEST['trackName'] == "" && $_REQUEST['artist'] == "" && $_REQUEST['genre'] == "")
{
    logError("empty parameter:  the name : " . $_REQUEST['trackName'] . ' or the artist : ' $_REQUEST['artist'] . ' or the genre : ' . $_REQUEST['genre']);
    $uploadOk = false;
}

do //Generate name file
{
    $newfilename = bin2hex(random_bytes(8));
    $target_file = 'music/' . $newfilename;

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
        logError("The file ". $_FILES['fileToUpload']['tmp_name']). " has been uploaded  and renamed to $target_file.");
        if(hasGenre($_REQUEST['genre']))
        {
            registerSong($newfilename, $_REQUEST['artist'], $_REQUEST['trackName'], $_REQUEST['genre']);            
        }
    }
    else
    {
        logError("There was an error moving file ". $_FILES['fileToUpload']['tmp_name'] . " to " . $target_file);
    }
}

return $uploadOk;