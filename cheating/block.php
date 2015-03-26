<?php
	//phpstuff
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];

	$db->openConnection();

	$cookies = $db->getRecipes();
	$db->closeConnection();
	
?>

<html>
<head><title>Block pallet</title><head>
<body><h1>Block pallet</h1>
	<form method=post action="blocked.php">
		Block pallet with the same cookies as Id:<br>
		<input type="text" name="bID"><br>
		(use this if you remember the ID of the pallet but can't<br>
		remember what kind of cookies the pallet contained)<br>
		-- or --<br>
		block by sort of cookie:<br>
		Cookie: <?php
			echo "<select name='searchValue'><option value=''>---</option>";
			foreach ($cookies as $row) {
				echo "<option value='". $row[0]. "'>" . $row[0] ."</option>";
				}
			echo "</select>";
		?><br>
		

		(use this if you remember what kind of cookies the pallet<br>
		contained but can't remember the ID of the pallet)<br>
		--- Select time frame --- <br>
		from (yy-mm-dd hh:mm:ss):<br>
		<input type="datetime" name="startTime"><br>
		to (yy-mm-dd hh:mm:ss):<br>
		<input type="datetime" name="endTime"><br>
		if the start time is omited it will recieve its default value<br>
		which is "00:00:00" the same day as the pallet was labeled.<br>
		if the end time is omited it will recieve its default value<br>
		which is "23:59:59" the same day as the pallet was labeled<br>
		
		<input type=submit value="Block">
	</form>


	<p>
	<form method=post action="index.php">
        	<input type=submit value="Return">
	</form>
</body>
</html>
