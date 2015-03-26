<?php
	require_once('database.inc.php');
	
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	
	$result = $db->inventory();

	$db->closeConnection();

?>

<html>
<head><title>Search Results</title><head>
<body><h1>Search Results</h1>
        <?php
                        echo "<table border='1'><tr><th>Name</th><th>AmountStorage</th><th>LastDelivery</th><th>LastAmount</th></tr>";
                        foreach ($result as $row) {
                                print ($row[0]!=null) ? "<td>".$row[0]."</td>": "<td>Not specified</td>";
                                print ($row[1]!=null) ? "<td>".$row[1]."</td>": "<td>Not specified</td>";
                                print ($row[2]!=null) ? "<td>".$row[2]."</td>": "<td>Not specified</td>";
                                print ($row[3]!=null) ? "<td>".$row[3]."</td>": "<td>Not specified</td>";
                                print "</tr>";
                        }
                        print "</table>";

         ?>

<p>
<form method=post action="index.php">
	<input type=submit value="Return to main menu">
</form>

