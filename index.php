<?php
	//PHP here to connect to db
	require_once('database.inc.php');
	require_once("mysql_connect_data.inc.php");
	$db = new Database($host, $userName, $password, $database);
	$db->openConnection();

	if (!$db->isConnected()){
		header("location: cannotConnect.html");
		exit();
	}
	
	$db->closeConnection();
	

	session_start();
	$_SESSION['db'] = $db;
?>

<html>
<head><title>Krusty Kookies AB</title></head>
<body>
<h1 align = "center">Choose option</h1>

<p>
<!-- Buttons! -->
<form method = post action = "listIngredients.php">
	<input type=submit value="List available ingredients">
</form>

<form method = post action = "listRecipes.php">
	<input type=submit value="List recipes">
</form>

<form method = post action = "addRecipes.php">
	<input type=submit value="Add recipes">
</form>

<form method = post action = "block.php">
	<input type=submit value="Block cookies">
</form>

<form method = post action = "placeorder1.php">
	<input type=submit value="Place order">
</form>

<form method = post action = "search.php">
	<input type=submit value="Search">
</form>
</body>
</html>
