<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$recipeName = isset($_POST['recipeName']) ? $_POST['recipeName'] : false;
	$ingredientName = isset($_POST['Ingredient']) ? $_POST['Ingredient'] : false;
	$amount = isset($_POST['amount']) ? $_POST['amount'] : false;


	$db->openConnection();
	$result = $db->addCookie($recipeName);

	$recipe = $db->getIngredientsForCookie($recipeName);
	$db->closeConnection();

?>

<html>
<head><title>Add Recipe</title><head>
<body><h1>Add Recipe</h1>
	<p>
	Recipe name: $recipeName
	<br>
	<form>
		<?php
			$first = true;
			foreach ($recipe as $name) {
				if ($first) {
					print "<option selected>";
					$first = false;
				} else {
					print "<option>";
				}
				print $name[0];
			}
		?>
		<p>
		<input type="hidden" name="recipeName" value="<?php echo $recipeName ?> "/>
	</form>
	<p>
	<form method=post action="addRecipes2.php">
	<input type=submit value="continue">
</form>
</body>
</html>
