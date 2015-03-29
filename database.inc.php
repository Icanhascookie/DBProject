<?php

class Database {
	private $host;
	private $userName;
	private $password;
	private $database;
	private $conn;

	public function __construct($host, $userName, $password, $database) {
		$this->host = $host;
		$this->userName = $userName;
		$this->password = $password;
		$this->database = $database;
	}
	
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

	public function closeConnection() {
		$this->conn = null;
		unset($this->conn);
	}

	public function isConnected() {
		return isset($this->conn);
	}
	
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

	private function executeUpdate($query, $param = null) {
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
	//Add Functions
	
	public function block($cookieName, $startDate, $endDate){
        $sql = "UPDATE Pallet SET isBlocked=1 WHERE cookieName = ? AND productionDate BETWEEN ? AND ?" ;
        $result = $this->executeUpdate($sql, array($cookieName, $startDate, $endDate));
	return $result;
	}
	public function unblock($cookieName, $startDate, $endDate){
        $sql = "UPDATE Pallet SET isBlocked=0 WHERE cookieName=$cookieName AND productionDate BETWEEN $startDate AND $endDate" ;
        $result = $this->executeUpdate($sql, array($cookieName, $startDate, $endDate));
	return $result;
	}
	public function deliverPallet($palletID, $deliveredDate){
	$sql = "UPDATE Pallet SET deliveredDate = ? WHERE palletID = ?";
	$result = $this->executeUpdate($sql, array($deliveredDate, $palletID));
	return $result;
	}
	public function producePallet($cookieName, $productionDate, $deliveredDate, $orderNbr){
	$sql = "INSERT INTO Pallet (cookieName, productionDate, deliveredDate, orderNbr) VALUES (?,?,?,?)";
	$result = $this->executeUpdate($sql, array($cookieName, $productionDate, $deliveredDate, $orderNbr));
	return $result;
	}
	public function getIngredientsForCookie($cookieName){
	$sql = "SELECT * FROM Recipe WHERE cookieName= ?";
	$result = $this->executeQuery($sql, array($cookieName));
	return $result;
	}
	public function updateIngredient($ingredient, $newAmount){
	$sql = "UPDATE Ingredient SET amount = ? WHERE name = ?";
	$result = $this->executeUpdate($sql, array($newAmount, $ingredient));
	return $result;
	}
	public function getAllIngredients(){
	$sql = "SELECT * FROM Ingredient";
	$result = $this->executeQuery($sql);
	return $result;
	}
	//I was thinking we do most of the logic in the php files that call these functions. Not sure if thats a good way to do it.
}?>
