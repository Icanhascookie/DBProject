<?php

	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();

	/*if (($db->isConnected())){
		header('location: cannotConnect.html');
		exit();
	}*/
	
	$recipes = $db->getRecipes();
	$db->closeConnection();

?>

<html>
<head>
<title>Label Pallet</title>
</head>
<body>

<h1 align="center">Label Pallet</h1>
Select type of cookies:
<p>
<form method=post action="generated.php">
	<select name="recipe" size=10>
	<?php
		$first = true;
		/*
		 * List types of cookies when databasket
		 * is implemented and accessible.
		*/

		foreach ($recipes as $rec) {
			if ($first){
				print "<option selected>";
				$first = false;
			} else {
				print "<option>";
			}
			print $rec['name'];
		}
	?>
	</select>
	<input type="number" name="amount">
	<input type=submit value="Create label">
</form>

<p>
<form method=post action="index.php">
	<input type=submit value="Return">
</form>
</body>
</html>
