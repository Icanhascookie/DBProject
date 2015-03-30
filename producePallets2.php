<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$cookieName = isset($_POST['cookie']) ? $_POST['cookie'] : false;
	$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : false;
	if(!($cookieName  && $quantity)){
		echo "Somethings was not selected correctly!";
		$result = false;
	}
	else if(!is_numeric($quantity)){
		echo "Quantity is not a number!";
		$result = false;
	}
	else{
		$db->openConnection();
		$result = $db->order($customerName, $cookieName, $quantity, $deliveryDate);
		$db->closeConnection();
	}
?>
<?php
if($result){
echo "
<html>
<head><title>Production successful</title><head>
<body><h1>Pallets successfully produced!</h1>
	<p>
	Type of cookie: $cookieName
	<br>
	Amount of pallets: $quantity
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
