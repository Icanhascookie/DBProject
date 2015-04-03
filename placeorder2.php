<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$customerName = isset($_POST['Customer']) ? $_POST['Customer'] : false;
	if($customerName){
		$db->openConnection();
		$cookieName = $db->getCookies();
		$db->closeConnection();
	}
	else{
		echo "Customer was not selected!";
	}
?>

<html>
<head><title>Select cookie</title><head>
<body><h1>Select cookie</h1>
	Selected Customer: <?php print $customerName ?>
	<p>
	Select cookie:
	<p>
	<form method=post action="placeorder3.php">
		<select name="Cookie" size=10>
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
		<input type="hidden" name="Customer" value="<?php echo $customerName ?> "/>
		<input type=submit value="Select cookie">
	</form>
	<p>
	<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>
</body>
</html>
