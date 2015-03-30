<?php
	session_start();
	$customerName = $_SESSION['Customer'];
	$cookieName = $_REQUEST['Cookie'];

	$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : false;
	$deliverDate = isset($_POST['deliverDate']) ? $_POST['deliverDate'] : false;
?>

<html>
<head><title>Enter order quantity and deliver date</title><head>
<body><h1>Enter order quantity and deliver date</h1>
	<p>
	Selected Customer: <?php print $customerName ?>
	<br>
	Selected Cookie: <?php print $cookieName ?>
	<br>
	<form method=post action="placeorder3.php">
		order quantity:<br>
		<input type="text" name="quantity"><br>
		deliver date (yyyy-mm-dd): <br>
		<input type="datetime" name="deliverDate"><br>
	</form>
	<form method=post action="placeorder3.php">
		<input type=submit value="Place order">
	</form>
</body>
</html>
