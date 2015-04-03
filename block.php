
<?php 
	require_once('database.inc.php');
	session_start();
	$db = $_SESSION['db'];
	$db->openConnection();
	$cookieName = isset($_POST['cName']) ? $_POST['cName'] : false;
	$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : false;
	$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : false;
	if($cookieName && $startDate && $endDate){
	if(isset($_POST['Block'])){
		$db->block($cookieName, $startDate, $endDate);
		$db->closeConnection();
	}
	else if(isset($_POST['Unblock'])){
		$db->unblock($cookieName, $startDate, $endDate);
		$db->closeConnection();
	}
	else{
		echo "invalid form";
	}
}
?>
<html>
<head><title>Block</title><head>
<body><h1>Block</h1>
	<form method=post action="block.php">
		Block/Unblock pallet with this type of cookie:<br>
		<input type="text" name="cName"><br>
		<b>Time interval:</b> <br>
		from (yyyy-mm-dd):<br>
		<input type="datetime" name="startDate"><br>
		to (yyyy-mm-dd):<br>
		<input type="datetime" name="endDate"><br>
		<input type=submit name="Block" value="Block">
		<input type=submit name="Unblock" value="Unblock">
	</form>


	<p>
	<form method=post action="index.php">
        	<input type=submit value="Return">
	</form>
</body>
</html>
