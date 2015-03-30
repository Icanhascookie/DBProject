<?php
	$recipeName = isset($_POST['recipeName']) ? $_POST['recipeName'] : false;
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];

	$db->openConnection();
	$ingredientName = $db->getIngredientName();
	$db->closeConnection();
?>

<html>
<head><title>Add Recipes</title><head>
<body><h1>Add Recipes</h1>
	New recipe: <?php print $recipeName ?>
	<p>
	Select ingredient:
	<p>
	<form method=post action="addRecipesDone.php">
		<select name="Ingredient" size=10>
		<?php
			$first = true;
			foreach ($ingredientName as $name) {
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
		<p>
		Enter amount used:<br>
		<input type="text" name="amount"><br>
		<input type="hidden" name="recipeName" value="<?php echo $recipeName ?> "/>

		<input type=submit value="Select ingredient">
	</form>

	<p>
	<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>
</body>
</html>
