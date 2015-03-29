<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	
	$cookies = $db->getCookies();
	$db->closeConnection();

?>

<html>
<head><title>Recipe List</title><head>
<body><h1 align = "center">Recpie Lists</h1>
        <?php

        foreach($cookies as $cookie){
		echo "<b>" . $cookie['name'] . "</b>";
		$db->openConnection();
		$ingredients = $db->getIngredientsForCookie($cookie['name']);
		$db->closeConnection();
		foreach($ingredients as $ingredient){
			echo '<table class="table table-striped table-bordered table-hover">'; 
			echo "<tr><td>";
			echo $ingredient['ingredientName'];
			echo "</td><td>";
			echo $ingredient['amountUsed'];
			echo "</td></tr>"; 
			echo "</table>";
		}
		echo "</br>";
	}
					
         ?>

<p>
<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>
</body>
</html>
