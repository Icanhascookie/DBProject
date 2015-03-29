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
	echo '<table class="table table-striped table-bordered table-hover">'; 
	echo "<tr><th>Name</th><th>Amount:</th></tr>"; 
        foreach($result as $r){
		echo "<tr><td>";
		echo $r['name'];
		echo "</td><td>";
		echo $r['amount'];
		echo "</td></tr>"; 
	}
	echo "</table>";
         ?>

<p>
<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>
</body>
</html>
