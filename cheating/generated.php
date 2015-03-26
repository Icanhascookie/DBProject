<?php
	require_once('database.inc.php');
	
	session_start();
	
	$db = $_SESSION['db'];
	$db->openConnection();
	
	$_SESSION['recipe'] = $_REQUEST['recipe'];
	$_SESSION['amount'] = $_REQUEST['amount'];
	$recipe = $_SESSION['recipe'];
	$amount = $_SESSION['amount'];
	if (!$recipe){
		header('location: cannotConnect.html');
		exit();
	}	
	$result = $db->label($recipe,$amount);
	
	$db->closeConnection();

	$output = (empty($result)) ? "No pallets were generated, did you select an amount of pallets to generate?": "Successfully generated $amount pallets!";
?>

<html>
<head><title>Generate pallet</title><head>
<body><h1>Label pallet</h1>
	<?php print $output; ?> <br>
	<?php
		if (!empty($result)) {
			print "Unique generated pallet IDs: ";
			foreach ($result as $o) {
				print "$o\n\r";
			}
		}
	?> <p>
	

<form method=post action="generate.php">
        <input type=submit value="Generate More Pallets">
</form>
<form method=post action="index.php">
        <input type=submit value="Return to main menu">
</form>


</body>
</html>
