<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$orderNumber = isset($_POST['orderNumber']) ? $_POST['orderNumber'] : false;
	if(!($orderNumber)){
		echo "Not a valid order number!";
		$result = false;
	}
	else{
		$db->openConnection();
		$order = $db->getOrderQuantity($orderNumber);
		$nbrOfPallets = $order[0]['quantity'];	
		$result = $db->producePallet($order[0]['cookieName'],$deliveryDate, $orderNumber, $nbrOfPallets);
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
	The pallets have been produced for order number: $orderNumber 
	<br>
	Amount of pallets: $nbrOfPallets
	<p>
<form method=post action='index.php'>
	<input type=submit value='Return to main menu'>
</form>
</body>
</html>";

}
else{
	echo "Something went wrong :( Maybe you ordered way too many pallets and we can't afford to produce them.";
}
?>
