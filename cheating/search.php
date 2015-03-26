<?php
	//php stuff here...
	require_once('database.inc.php');
	
	session_start();

	$db = $_SESSION['db'];
	$db->openConnection();
	
	$customers = $db->customers();
	$status = $db->statuses();
	$cookies = $db->getRecipes();	
	$db->closeConnection();
		
?>

<html>
<head><title>Search</title><head>
<body><h1>Search</h1>
	Search for pallet by: <br>
	<form method=post action="searchDone.php">
	Pallet ID: <input type="text" name="searchValue">
		<input type="hidden" name="type" value="id">
		<input type=submit value="Search">
	</form>
	--- or --- <br>
	<form action="searchDone.php" method="post">
	Cookie: <?php
	 echo "<select name='searchValue'><option value=''>---</option>";

        foreach ($cookies as $row) {
                echo "<option value='". $row[0]. "'>" . $row[0] ."</option>";
        }
        echo "</select>";
	?>
	<br>
	Specify the times in the format of "yyyy-mm-dd hh:mm:ss" <br>
	Start time:
		<input type="datetime" name="startTime">
	End time:
		<input type="datetime" name="endTime">
		<input type="hidden" name="type" value="cookieDate">
		<input type=submit value="Search">
		<br>
		It's not necessary to specify the time frame in witch to seach.<br>If the time frame is omited from the search the search will adapt to<br>the specified input. So for instance if you'd like to search for all <br>pallets that were created before a certain time, just omit the start time.

	</form>
	--- or --- <br>
	<form action="searchDone.php" method="post">
	Customer: <?php
	echo "<select name='searchValue'><option value=''>---</option>";

	foreach ($customers as $row) {
		echo "<option value='". $row[0]. "'>" . $row[0] ."</option>";
	} 
	echo "</select>";

	?>
		<input type="hidden" name="type" value="comp">
		<input type=submit value="Search">
			
	</form>
	--- or ---<br>
	<form method=post action="searchDone.php">
	Free text: <input type="text" name="searchValue">
		<input type="hidden" name="type" value="free">
		<input type=submit value="Search">
	</form>
	--- or --- <br>
	<form action="searchDone.php" method="post">
        status: <?php
        echo "<select name='searchValue'><option value=''>---</option>";

        foreach ($status as $row) {
                echo "<option value='". $row[0]. "'>" . $row[0] ."</option>";
        }
        echo "</select>";

        ?>
                <input type="hidden" name="type" value="status">
                <input type=submit value="Search">

        </form><p>


	
<p>
<form method=post action="index.php">
        <input type=submit value="Return">
</form>

</body>
</html>
