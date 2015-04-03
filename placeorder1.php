<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$customerNames = $db->getCustomerNames();
	$db->closeConnection();
?>

<html>
<head><title>Select customer</title><head>
<body><h1>Select customer</h1>

	Customers:
	<p>
	<form method=post action="placeorder2.php">
		<select name="Customer" size=10>
		<?php
			$first = true;
			foreach ($customerNames as $name) {
				if ($first) {
					print "<option selected>";
					$first = false;
				} else {
					print "<option>";
				}
				print $name[0];
			}
		?>
		</select>		
		<input type=submit value="Select customer">
	</form>
	<p>
	<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>
</body>
</html>
