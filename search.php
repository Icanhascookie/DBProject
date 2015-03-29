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


</body>
</html>