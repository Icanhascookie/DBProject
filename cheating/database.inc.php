<?php
/*
 * Class Database: interface to the movie database from PHP.
 *
 * You must:
 *
 * 1) Change the function userExists so the SQL query is appropriate for your tables.
 * 2) Write more functions.
 *
 */
class Database {
	private $host;
	private $userName;
	private $password;
	private $database;
	private $conn;
	
	/**
	 * Constructs a database object for the specified user.
	 */
	public function __construct($host, $userName, $password, $database) {
		$this->host = $host;
		$this->userName = $userName;
		$this->password = $password;
		$this->database = $database;
	}
	
	/** 
	 * Opens a connection to the database, using the earlier specified user
	 * name and password.
	 *
	 * @return true if the connection succeeded, false if the connection 
	 * couldn't be opened or the supplied user name and password were not 
	 * recognized.
	 */
	public function openConnection() {
		try {
			$this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", 
					$this->userName,  $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			$error = "Connection error: " . $e->getMessage();
			print $error . "<p>";
			unset($this->conn);
			return false;
		}
		return true;
	}
	
	/**
	 * Closes the connection to the database.
	 */
	public function closeConnection() {
		$this->conn = null;
		unset($this->conn);
	}

	/**
	 * Checks if the connection to the database has been established.
	 *
	 * @return true if the connection has been established
	 */
	public function isConnected() {
		return isset($this->conn);
	}
	
	/**
	 * Execute a database query (select).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters 
	 * @return The result set
	 */
	private function executeQuery($query, $param = null) {
		try {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($param);
			$result = $stmt->fetchAll();
		} catch (PDOException $e) {
			$error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
			die($error);
		}
		return $result;
	}
	
	/**
	 * Execute a database update (insert/delete/update).
	 *
	 * @param $query The query string (SQL), with ? placeholders for parameters
	 * @param $param Array with parameters 
	 * @return The number of affected rows
	 */
	private function executeUpdate($query, $param = null) {
		// ... 
		try {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($param);
			return $stmt->rowCount();
		} catch (PDOException $e) {
			$error = "*** Internal error" . $e->getMessage() . "<p>" . $query;
			$this->conn->rollBack();
			die($error);
		}
	}
	

	/*
	 * *** Add functions ***
	 */

	public function getRecipes(){
		
		$sql = "SELECT name FROM recipes";
		$result = $this->executeQuery($sql);
		
		return $result;
	}
	
	public function inventory(){
		$sql = "SELECT * FROM ingredients";
		$result = $this->executeQuery($sql);
		return $result;

	}
		
	//subject of latet name change.
	public function label($recipe, $nbrPallets = null){
		/*
		 * TODO
		 * query if it is possible to create the desiered amount of pallets
		 * and if so, remove the correct amount of ingredients from the storage...
		 */
		if ($nbrPallets == null) {
			return array();
		}

		if (!is_numeric($nbrPallets)) {
			return array();
		}
		if (!ctype_digit($nbrPallets)) {
			return array();
		}	
		
		$returnValue = -1;
		$this->conn->beginTransaction();
		
		//$nbrCookies = 15 * 10 * 36;		//nbr of cookies per pallet
		//print $nbrCookies;
		
		$sql = "SELECT ingredientName, amount FROM recipeLists WHERE recipeName = ?";
		$result = $this->executeQuery($sql, array($recipe));

		foreach($result as $row){
			$sql = "SELECT amountStorage FROM ingredients WHERE name = ?";
			$amount = $this->executeQuery($sql, array($row['ingredientName']));
			$needed = $row['amount'] * 54 * $nbrPallets;
			
			if ($needed > $amount[0]['amountStorage']){
				return false;
			}
		}

		//If you made it here... you are good to proceed to the next step and accually remove the needed ingredients from the storage

		foreach($result as $row) {
			$sql = "SELECT amountStorage FROM ingredients WHERE name = ?";
			$amount = $this->executeQuery($sql, array($row['ingredientName']));
			$left = $amount[0]['amountStorage'] - ($row['amount'] * 54 * $nbrPallets);
			$sql = "UPDATE ingredients SET amountStorage = ? WHERE name = ?";
			$this->executeUpdate($sql, array($left, $row['ingredientName']));
		}

		$returnValue = array();
		for ($i = 0; $i < $nbrPallets; $i++){
			$sql = "INSERT INTO pallets values(null, null, ?, 'labeled', null,null, NOW())";
			$result = $this->executeUpdate($sql, array($recipe));
			if ($result == 1) {
				$returnValue[] = $this->conn->lastInsertId();
			}
		}
		
		$this->conn->commit();
		return $returnValue;
	}

	public function registerToFreezer($id){
		$returnValue = -1;
		$this->conn->beginTransaction();
		$sql = "SELECT status FROM pallets where id = ?";
		$result = $this->executeQuery($sql,array($id));
		if (empty($result))
			return $returnValue;

			
		$sql = ($result == 'blocked') ? "UPDATE pallets SET timeCreated=NOW() WHERE id = ?": "UPDATE pallets SET timeCreated=NOW(), status='stored' WHERE id=?";

		$results = $this->executeUpdate($sql, array($id));
		
		$returnValue = $this->conn->lastInsertId();
	
		$this->conn->commit();

		return $returnValue;
	}
	
	public function customers(){
		$sql = "SELECT name FROM customers";
		$result = $this->executeQuery($sql);
		return $result;
	}
	
	public function statuses(){
		$sql = "SELECT status FROM statuses";
		$result = $this->executeQuery($sql);
		return $result;
	}

	public function block($id = null, $cookie = null, $startTime = null, $endTime = null) {
		$returnValue = -1;
		
		$eID = empty($id);
		$eC = empty($cookie);
		$eS = empty($startTime);
		$eE = empty($endTime);
		
		if ($eID && $eC && $eS && $eE){
			return $returnValue;
		}

		if (!empty($startTime)){
                        if (!$this->validateDate($startTime))
                                return -2;
                }
                if (!empty($endTime)){
                        if(!$this->validateDate($endTime))
                                return -2;
                }

		
		$this->conn->beginTransaction();
		$arr = array();

		$sql = "SELECT CAST(timeLabeled AS DATE) FROM pallets WHERE id = ?";
                $result = $this->executeQuery($sql, array($id));

                $dateLabeled = $result[0];
		$dateLabeled = $dateLabeled[0];

                $sql = "SELECT recipeName FROM pallets WHERE id = ?";
                $result = $this->executeQuery($sql, array($id));

                $c = $result[0];
                $c = $c[0];
		

		$sql = "";
		$sql = "UPDATE pallets SET status = 'blocked'";
		if (!$eID){
			$sql = " ".$sql." WHERE (recipeName = ?";
			$arr[] = $c;
			
		} else if (!$eC) {
			$sql = " ".$sql." WHERE (recipeName = ?";
			$arr[] = $cookie;
		}

		if (!$eID || !$eC){
			$sql = " ".$sql." AND";
		} else {
			$sql = " ".$sql." WHERE (";
		}
		$sql = " ".$sql." timeLabeled >= ?";
                if ($eS) {
			$arr[] = $dateLabeled." 00:00:00";
		} else {
			$arr[] = $startTime;
		}
		$sql = " ".$sql." AND timeLabeled <= ?)";
                if ($eE) {
			$arr[] = $dateLabeled." 23:59:59";
		} else {
			$arr[] = $endTime;
		}

		$result = $this->executeUpdate($sql, $arr);
		
		$this->conn->commit();
		return $result;

	}
		
	public function search($searchValue,$type,$startTime = null, $endTime = null) {
		$sql = "";
		$arr = null;
		if (!empty($startTime)){
			if (!$this->validateDate($startTime))
				return -1;
		}
		if (!empty($endTime)){
			if(!$this->validateDate($endTime))
				return -1;
		}
		switch($type) {
		case "id":
			$sql = "SELECT * FROM pallets WHERE id = ?";
			$arr = array($searchValue);
			break; 
		case "comp":
			$sql = "SELECT * FROM pallets WHERE customer LIKE ?";
			$searchValue = "%".$searchValue."%";
			$arr = array($searchValue);
			break;
		case "status":
			$sql = "SELECT * FROM pallets WHERE status = ?";
			$arr = array($searchValue);
			break;
		case "free":
			$searchValue = "%".$searchValue."%";
			$sql = "SELECT DISTINCT * FROM pallets WHERE id LIKE ? OR timeCreated LIKE ? OR recipeName LIKE ? OR status LIKE ? OR timeDelivered LIKE ? OR customer LIKE ?";
			$arr = array($searchValue,$searchValue,$searchValue,$searchValue,$searchValue,$searchValue);
			break;
		case "cookieDate":
			$searchValue = "%".$searchValue."%";		
			if (empty($startTime) && empty($endTime)) {
				$sql = "SELECT DISTINCT * FROM pallets WHERE recipeName LIKE ?";
				$arr = array($searchValue);
			} else if (empty($startTime) && !empty ($endTime)) {
				$sql = "SELECT DISTINCT * FROM pallets WHERE recipeName LIKE ? AND timeLabeled <= ?";
                                $arr = array($searchValue, $endTime);

			} else if (!empty($startTime) && empty($endTime)) {
				$sql = "SELECT DISTINCT * FROM pallets WHERE recipeName LIKE ? AND timeLabeled >= ?";
                                $arr = array($searchValue, $startTime);

			} else if (!empty($startTime) && !empty($endTime)) {
                                $sql = "SELECT DISTINCT * FROM pallets WHERE recipeName LIKE ? AND timeLabeled >= ? AND timeLabeled <= ?";

				$arr = array($searchValue, $startTime, $endTime);
			}
		}

		$result = $this->executeQuery($sql, $arr);
		
		return $result;
	}

	function validateDate($date, $format = 'Y-m-d H:i:s')
	{
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
	function isInteger($input){
		return(ctype_digit(strval($input)));
	}
}?>
