<?php
	require_once('database.inc.php');
	
	session_start();

	$db = $_SESSION['db'];
	$db->openConnection();


	$db->closeConnection();
?>

<html>
<head><title>Search</title><head>
<body><h1>Search</h1>
	<form method=post action="searchDone.php">
		Search for pallet by Pallet ID: <input type="text" name="searchValue">
		<input type="hidden" name="type" value="id">
		<input type=submit value="Search">
	</from>
	------ <br>

<p>
<form method=post action="index.php">
	<input type=submit value="Return">
</form>

</body>
</html>