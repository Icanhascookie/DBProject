<?php
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$result = false;
	$_SESSION['searchValue'] = $_REQUEST['searchValue'];
	$id = $_SESSION['searchValue'];
	$_SESSION['type'] = $_REQUEST['type'];
	$type = $_SESSION['type'];
	if ($type == "cookieDate") {
		$_SESSION['startTime'] = $_REQUEST['startTime'];
		$_SESSION['endTime'] = $_REQUEST['endTime'];
		$result = $db->search($id,$type,$_SESSION['startTime'],$_SESSION['endTime']);
	}else {
		$result = $db->search($id, $type);
	}
	$db->closeConnection();
?>


<html>
<head><title>Search Results</title><head>
<body><h1>Search Results</h1>
	<?php
		if ($result == -1) {
			print "Invalid input in Date/time field";
		} else if ((!empty($id)|| ($type=='cookieDate')) && (count($result) > 0) && $result != -1){
			echo "<table border = '1'><tr><th>ID</th><th>TimeCreated</th><th>recipeName</th><th>status</th><th>timeDelivered</th><th>customer</th><th>timeLabeled</th></tr>";
			foreach ($result as $row) {
				print ($row[0] != null) ? "<td>".$row[0]."</td>": "<td>Not specified</td>";
				print ($row[1] != null) ? "<td>".$row[1]."</td>": "<td>Not specified</td>";
				print ($row[2] != null) ? "<td>".$row[2]."</td>": "<td>Not specified</td>";
				print ($row[3] != null) ? "<td>".$row[3]."</td>": "<td>Not specified</td>";
				print ($row[4] != null) ? "<td>".$row[4]."</td>": "<td>Not specified</td>";
				print ($row[5] != null) ? "<td>".$row[5]."</td>": "<td>Not specified</td>";
				print ($row[6] != null) ? "<td>".$row[6]."</td>": "<td>Not specified</td>";
				print "</tr>";
			}
			print "</table>";

		} else {
			print "No matches were found";
		}
	 ?>

<p>
<form method = post action = "search.php">
        <input type = submit value = "Do another Search">
</form>
<form method = post action = "index.php">
	<input type = submit value = "Return to the main menu">
</form>


</body>
</html>
