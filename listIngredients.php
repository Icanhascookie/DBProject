<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	
	//$result = $db->functionname();
	//get list of ingredients here with db function.
	$db->closeConnection();

?>

<html>
<head><title>Search Results</title><head>
<body><h1 align = "center">Search Results</h1>
        <?php
                       //Nice print code here
					
         ?>

<p>
<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>

