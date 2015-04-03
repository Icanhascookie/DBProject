<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$orderNumbers = $db->getOrderNumbers();
	$db->closeConnection();
?>

<html>
<head><title>Produce pallets</title><head>
<body><h1>Produce pallets</h1>

	<p>
	Order numbers:
	<form method=post action="producePallets2.php">
		<select name="orderNumber" size=10>
		<?php
			$first = true;
			foreach ($orderNumbers as $number) {
				if ($first) {
					print "<option selected>";
					$first = false;
				} else {
					print "<option>";
				}
				print $number[0];
			}
		?>
		</select>
		</br>
		Amount of pallets of that type:
		<input type=submit value="Produce Order!">
	</form>
	<p>
	<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>
</body>
</html>
