<?php
//LAUNCH THE CONNECTION
    try 
    {
    	$bdd = new PDO($Dsn, $User, $Password);
    }
    catch (PDOException $e)
    {
    	echo 'An error as occured, Cannot connect to the database. Error: ' . $e->getMessage();
    }
?>
