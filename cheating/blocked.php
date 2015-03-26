<?php
	require_once('database.inc.php');
	session_start();
	$blockID = $_REQUEST['bID'];
	$blockCookie = $_REQUEST['bCookie'];
	$startTime = $_REQUEST['startTime'];
	$endTime = $_REQUEST['endTime'];
	 
	$db = $_SESSION['db'];
	$db->openConnection();
	$result = $db->block($blockID,$blockCookie, $startTime, $endTime);
	$output = ($result!='-1') ? "$result pallets was successfully blocked":"Something went wrong, please try again.";
	if ($result == -2)
		$output = "Invalid date/time format.";

	$db->closeConnection();
?>

<html>
<head><title>Block pallet</title><head>
<body><h1>Block pallet</h1>
	<?php print $output; ?>

	<form method=post action="block.php">
		<input type=submit value="Block more pallets">
	</form>
	<form method=post action="index.php">
		<input type=submit value="Return to main menu">
	</from>
</body>
</html>

