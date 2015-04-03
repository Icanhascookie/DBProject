<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$cookieName = isset($_POST['Cookie']) ? $_POST['Cookie'] : false;
	$customerName = isset($_POST['Customer']) ? $_POST['Customer'] : false;
	$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : false;
	$deliveryDate = isset($_POST['deliveryDate']) ? $_POST['deliveryDate'] : false;
	if(!($cookieName && $customerName && $quantity && $deliveryDate)){
		echo "Somethings was not selected correctly!";
		$result = false;
	}
	else if(!is_numeric($quantity)){
		echo "Quantity is not a number!";
		$result = false;
	}
	//We probably should check Date as well, but its a bit harder.
	else{
		$db->openConnection();
		$result = $db->order($customerName, $cookieName, $quantity, $deliveryDate);
		$db->closeConnection();
	}
?>
<?php
if($result != false){
echo "
<html>
<head><title>Order successful!</title><head>
<body><h1>Order successful! Your order ID is: $result</h1>
	<p>
	Selected Customer: $customerName
	<br>
	Selected Cookie: $cookieName
	<br>
	Selected Quantity: $quantity
	<br>
	Selected Delivery date: $deliveryDate
	<br>
	
	<p>
<form method=post action='index.php'>
	<input type=submit value='Return to main menu'>
</form>
</body>
</html>";

}
else{
	echo "Something went wrong :( ";
}
?>
