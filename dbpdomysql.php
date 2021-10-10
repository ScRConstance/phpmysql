<?php
class dbpdomysql_connect {
	private $server = 'localhost';
	private $user = 'php';
	private $pass = 'password';
	private $dbase ='dbase' ;
	private $conn;

	public function connect () {
		if ($this->conn==null) {
			$this->conn = new PDO("mysql:host=$this->server;dbname=$this->dbase", $this->user, $this->pass);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return $this->conn;
	}
}


class dbpdomysql {

//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
private $conn;

public function __construct($conn) {
	$this->conn = $conn;
}

/* PDO */
public function createdb ($dbase) {
	$sql_createdb = 'CREATE DATABASE IF NOT EXISTS ' .$dbase;
	$this->conn->exec($sql_createdb);
}

public function createtbl ($tbl) {
	$sql_createtbl ="CREATE TABLE IF NOT EXISTS $tbl (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
																					firstname VARCHAR(30) NOT NULL,
																					lastname VARCHAR(30) NOT NULL,
																					email VARCHAR(50),
																					regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
																					friends VARCHAR(50)
																					)";
	$this->conn->exec($sql_createtbl);
}

public function insertdata ($tbl, $fields) {
	$stmt = $this->conn->prepare("INSERT INTO $tbl (firstname, lastname, email, friends) VALUES (:firstname, :lastname, :email, :friends)");
	$stmt->bindParam(':firstname', $fields['firstname']);
	$stmt->bindParam(':lastname', $fields['lastname']);
	$stmt->bindParam(':email', $fields['email']);
	$stmt->bindParam(':friends', $fields['friends']);
	$stmt->execute();

	return $this->conn->lastInsertId();
}

public function getdata ($tbl, $id) {
	if ($id) {
		$friends = $this->conn->prepare("SELECT friends from $tbl where id =$id");
		$friends->execute();
		$friends->setFetchMode(PDO::FETCH_ASSOC);
		$friend = $friends->fetchAll();
		$stmt = $this->conn->prepare("SELECT * FROM $tbl WHERE id IN (" .$friend[0]['friends']. ")");
	}
	else {
		$stmt = $this->conn->prepare("SELECT * FROM $tbl");
	}
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	return $stmt->fetchAll();
}

public function deletedata ($tbl, $id) {
	$sql = "DELETE FROM $tbl WHERE id=$Id";
	$conn->exec($sql);
	echo "Record deleted successfully";
}

public function updatedata ($tbl, $id) {
	$sql = "UPDATE $tbl SET lastname='Doe' WHERE id=$id";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	echo $stmt->rowCount() . " records UPDATED successfully";	
}

public function close() {
	try {
		$conn = null;
	}
	catch(PDOEXCEPTION $e) {
		echo "Connection Failed: " . $e->getMessage();
	}
}

}
?>