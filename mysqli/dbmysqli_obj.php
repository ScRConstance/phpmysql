<?php
class dbmysqli_obj_connect {
	private $server = 'localhost';
	private $user = 'php';
	private $pass = 'matkhau';
	private $dbase ='dbase' ;
	private $conn;

	public function connect() {
		if ($this->conn == null)
			$this->conn = new mysqli($this->server, $this->user, $this->pass, $this->dbase);
		if($this->conn->connect_error)
			die('Connection Failed: ' . $this->conn->connect_error);
		else 
			return $this->conn;
	}
}

class dbmysqli_obj {

//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
private $conn;

public function __construct($conn) {
	$this->conn = $conn;
}

/* MySQLi (object-oriented) */
public function createdb ($dbase) {
	$sql_createdb = "CREATE DATABASE IF NOT EXISTS $dbase";
	if ($this->conn->query($sql_createdb) === TRUE) 
		echo 'Database created<br>';
	else
		echo 'Database created error: ' . $sql_createdb ."<br>". $this->conn->error;
}

public function createtbl ($tbl) {
	$sql_createtbl ="CREATE TABLE IF NOT EXISTS $tbl (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
									firstname VARCHAR(30) NOT NULL,
									lastname VARCHAR(30) NOT NULL,
									email VARCHAR(50),
									regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
									friends VARCHAR(50)
									)";
	if ($this->conn->query($sql_createtbl) !== TRUE) 
		echo 'Table created error: ' . $sql_createtbl ."<br>". $this->conn->error;
}

public function insertdata ($tbl, $fields) {
	$stmt = $this->conn->prepare("INSERT INTO $tbl (firstname, lastname, email) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $fields['firstname'], $fields['lastname'], $fields['email']);
	$stmt->execute();
}

public function getdata ($tbl) {
	$sql = "SELECT id, firstname, lastname FROM $tbl WHERE lastname LIKE '%Last%'";
	//return $this->conn->query($sql);
	
	$result = $this->conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<table><tr><th>ID</th><th>Name</th></tr>";
		while($row = $result->fetch_assoc()) {
			echo "<tr><td style='width:50px; border-bottom:1px solid #000000'>".$row["id"]."</td><td style='width:350px; border-bottom:1px solid #000000'>".$row["firstname"]." ".$row["lastname"]."</td></tr>";
		}
		echo "</table>";
	}
}

public function deletedata ($tbl, $id) {
	$sql = "DELETE FROM $tbl WHERE id=$id";
	if ($this->conn->query($sql) === TRUE) {
		echo "Record deleted successfully";
	}
	else {
		echo "Error deleting record: " . $this->conn->error;
	}	
}

public function updatedata ($tbl, $id) {
	$sql = "UPDATE $tbl SET lastname='Doe' WHERE id=$id";
	if ($this->conn->query($sql) === TRUE) {
		echo "Record updated successfully";
	}
	else {
		echo "Error updating record: " . $conn->error;
	}	
}

public function close () {
	$stmt->close();
	$conn->close();
}

}
?>
