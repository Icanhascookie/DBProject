<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$cookieName = $db->getOrderNumbers();
	$db->closeConnection();
?>

<html>
<head><title>Produce pallets</title><head>
<body><h1>Produce pallets</h1>

	<p>
	Type of cookie on the pallet:
	<form method=post action="placeorder2.php">
		<select name="cookie" size=10>
		<?php
			$first = true;
			foreach ($cookieName as $name) {
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
		</br>
		Amount of pallets of that type:
		<input type="text" name="quantity"><br>
		<input type=submit value="Select customer">
	</form>
	<p>
	<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>
</body>
</html>
