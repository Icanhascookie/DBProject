<?php
	require('dsek.php');
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

	//header('location: main.php');

?>

<html>
<head><title>Main</title><head>

<body><h1>Main</h1>
	<h4>Panels for generating the necessary pallets for testing:</h4>
	<form method=post action="generate.php">
                <input type=submit value="Produce Pallets">
	Create and label a given number of pallets. The pallets that will be created will be numbered ascending in the order they are created.
        </form>
	
	<form method=post action="listInventory.php">
		<input type=submit value="List Inventory">
	List the inventory to see if there is any chance to make those delicious cookies!
        </form>
        
	<h4>Panels for simulating the system:</h4>
	<form method=post action="register.php">
                <input type=submit value="Register">
		 a pallet to the freezer storage via a bar code scanner.
        </form>
        <form method=post action="search.php">
                <input type=submit value="Search">
		for pallets
        </form>
        <form method=post action="block.php">
                <input type=submit value="Block">
		pallets that have been created in a certain timeframe.
	</form>
</body>
</html>

