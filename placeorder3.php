<?php
	$cookieName = isset($_POST['Cookie']) ? $_POST['Cookie'] : false;
	$customerName = isset($_POST['Customer']) ? $_POST['Customer'] : false;
	if($customerName == false || $cookieName == false){
		echo "Cookie/Customer was not selected!";
	}
?>

<html>
<head><title>Enter order quantity and deliver date</title><head>
<body><h1>Enter order quantity and deliver date</h1>
	<p>
	Selected Customer: <?php print $customerName ?>
	<br>
	Selected Cookie: <?php print $cookieName ?>
	<br>
	<form method=post action="placeorder4.php">
		Order quantity:<br>
		<input type="text" name="quantity"><br>
		Delivery date (yyyy-mm-dd): <br>
		<input type="datetime" name="deliveryDate"><br>
		<input type="hidden" name="Customer" value="<?php echo $customerName ?> "/>
		<input type="hidden" name="Cookie" value="<?php echo $cookieName ?> "/>
		<input type=submit value="Place order">
	</form>
	
	<p>
	<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>
</body>
</html>
