<?php
	require_once('database.inc.php');

	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	
	$barCode = $_REQUEST['barCode'];
	
	$result = $db->registerToFreezer($barCode);
	$db->closeConnection();
	$outPut = ($result != -1) ? "Registration of pallet: $barCode was successful": "Something went wrong. You most likely tried to register a pallet that doesn't have a correct ID number. Please contact your technican if the problem remains.";
?>

<html>
<head><title>Register Pallet</title><head>
<body><h1>Register Pallet</h1>
	<?php print $outPut ?>
	<p>
        <form method=post action="index.php">
        <input type=submit value="Return">
        </form>
</body>
</html>
