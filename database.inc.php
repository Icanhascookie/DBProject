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
		$sql = "INSERT INTO Pallet (cookieName, productionDate, deliveredDate, orderNbr) VALUES (?,CURDATE(),?,?)";
		$result = $this->executeUpdate($sql, array($cookieName, $deliveredDate, $orderNbr));
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
	public function getCookies(){
		$sql = "SELECT * FROM Cookie";
		$result = $this->executeQuery($sql);
		return $result;
	}
	public function getCustomerNames(){
		$sql = "SELECT name FROM Customer";
		$result = $this->executeQuery($sql);
		return $result;
	}
	public function order($customerName, $cookieName, $quantity, $deliveryDate){
		$this->conn->beginTransaction();
		$sql = "INSERT INTO Orders (orderNbr, customerName, deliveryDate) VALUES (NULL, ?, ?)";
		$this->executeUpdate($sql, array($customerName, $deliveryDate));
		$last_id = $this->conn->lastInsertId('Orders');
		$sql = "INSERT INTO OrderQuantity (cookieName, orderNbr, quantity) VALUES (?, LAST_INSERT_ID(), ?)";
		$result = $this->executeUpdate($sql, array($cookieName, $quantity));
		return $last_id;
	}

	public function getOrderNumbers(){
		$sql = "SELECT orderNbr FROM Orders";
		$result = $this->executeQuery($sql);
		return $result;
	}

	public function getDeliveredDate($status) {
		if ($status == true) {
			$sql = "SELECT * FROM Pallet WHERE DeliveredDate IS NOT NULL";
		} else {
			$sql = "SELECT * FROM Pallet WHERE DeliveredDate IS NULL";		
		}
		$result = $this->executeQuery($sql);
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
			$sql = "SELECT * FROM pallet WHERE palletID = ?";
			$arr = array($searchValue);
			break; 
		case "comp":
			$sql = "SELECT * FROM pallet WHERE orderNbr = (SELECT orderNbr FROM orders WHERE customerName = ?)";
			$searchValue = "%".$searchValue."%";
			$arr = array($searchValue);
			break;
		case "status":
			$sql = "SELECT * FROM pallet WHERE deliveredDate = ?";
			$arr = array($searchValue);
			break;
		case "cookieDate":
			$searchValue = "%".$searchValue."%";		
			if (empty($startTime) && empty($endTime)) {
				$sql = "SELECT DISTINCT * FROM pallet WHERE cookieName LIKE ?";
				$arr = array($searchValue);
			} else if (empty($startTime) && !empty ($endTime)) {
				$sql = "SELECT DISTINCT * FROM pallet WHERE cookieName LIKE ? AND productionDate <= ?";
                                $arr = array($searchValue, $endTime);

			} else if (!empty($startTime) && empty($endTime)) {
				$sql = "SELECT DISTINCT * FROM pallet WHERE cookieName LIKE ? AND productionDate >= ?";
                                $arr = array($searchValue, $startTime);

			} else if (!empty($startTime) && !empty($endTime)) {
                                $sql = "SELECT DISTINCT * FROM pallet WHERE cookieName LIKE ? AND productionDate >= ? AND productionDate <= ?";

				$arr = array($searchValue, $startTime, $endTime);
			}
		}

		$result = $this->executeQuery($sql, $arr);
		
		return $result;
	}

	function validateDate($date, $format = 'Y-m-d H:i:s'){
	    $d = DateTime::createFromFormat($format, $date);
	    return $d && $d->format($format) == $date;
	}
}?>
