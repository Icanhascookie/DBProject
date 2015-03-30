<?php
	require_once('database.inc.php');
	
	session_start();

	$db = $_SESSION['db'];
	$db->openConnection();
	$cookies = $db->getCookies();	
	$customers = $db->getCustomerNames();
	$db->closeConnection();
?>

<html>
<head><title>Search</title><head>
<body><h1>Search</h1>
	<form method = post action = "searchDone.php">
		Search for pallet by Pallet ID: <input type = "text" name = "searchValue">
		<input type = "hidden" name = "type" value = "id">
		<input type = submit value = "Search">
	</form>

	<br> ------ <br>

	<form action = "searchDone.php" method = "post">
	Search for pallet by type of Cookie: <?php
	 echo "<select name = 'searchValue'><option value = ''>---</option>";
        foreach ($cookies as $row) {
                echo "<option value = '". $row[0]. "'>" . $row[0] ."</option>";
        }
        echo "</select>";
	?>
	<br>
	and production time: <br>
	Specify the times in the format of "yyyy-mm-dd hh:mm:ss" <br>
	Start time:
		<input type = "datetime" name = "startTime">
	End time:
		<input type = "datetime" name = "endTime">
		<input type = "hidden" name = "type" value = "cookieDate">
		<input type = submit value = "Search">
		<br>
		You don't have to specify both the Start time and End time for this search.<br>If the time frame is left out from the search the search will adapt to<br>the specified input. So for instance if you'd like to search for all <br>pallets that were created before a certain time, just leave out the start time.
	</form>
	------ <br>
	<form action = "searchDone.php" method = "post">
	Search for pallet by Customer: <?php
	echo "<select name = 'searchValue'><option value = ''>---</option>";

	foreach ($customers as $row) {
		echo "<option value = '". $row[0]. "'>" . $row[0] ."</option>";
	} 
	echo "</select>";

	?>
		<input type = "hidden" name = "type" value = "comp">
		<input type = submit value = "Search">
			
	</form>
	------ <br>
	<form action = "searchDone.php" method = "post">
        Search for pallet by Status: <?php
        echo "<select name = 'searchValue'><option value = ''>---</option>";
		echo "<option value = 'null'>Not Delivered</option>";
  		echo "<option value = '2'>Delivered</option>";
		echo "<option value = '1'>Blocked</option>";
		echo "<option value = '0'>Not Blocked</option>";
        echo "</select>";

        ?>
                <input type = "hidden" name = "type" value = "status">
                <input type = submit value = "Search">

        </form><p>
<p>
<form method = post action = "index.php">
	<input type = submit value = "Return">
</form>

</body>
</html>
