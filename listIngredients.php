<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	
	$result = $db->getAllIngredients();
	$db->closeConnection();

?>

<html>
<head><title>Ingredient List</title><head>
<body><h1 align = "center">Ingredient Lists</h1>
        <?php
                       //Nice print code here
		       foreach($result as $r){
			echo $r;
		       }
					
         ?>

<p>
<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>
</body>
</html>
