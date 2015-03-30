<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$customerName = $_REQUEST['Customer'];
	
	$db->openConnection();
	
	$cookieName = $db->getCookies();
	$_SESSION['cookieName'] = $cookieName;
	$_SESSION['Customer'] = $customerName;
	$db->closeConnection();
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
		<input type=submit value="Select cookie">
	</form>
</body>
</html>
