<?php

//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$server = 'localhost';
$user = 'php';
$pass = 'password';
$dbase ='dbase' ;

/* MySQLi (procedural)*/
$conn = mysqli_connect($server, $user,$pass, $dbase);
if(!$conn)
	die('Connection Failed: ' . mysqli_connect_error());
else 
	echo 'Connect successfully<br>';

$sql_createdb = 'CREATE DATABASE IF NOT EXISTS dbase';
if (mysqli_query($conn, $sql_createdb))
	echo 'Database created<br>';
else
	echo 'Database created error: ' . $sql_createdb ."<br>". mysqli_error($conn);

$sql_createtbl ='CREATE TABLE IF NOT EXISTS guests(id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
								firstname VARCHAR(30) NOT NULL,
								lastname VARCHAR(30) NOT NULL,
								email VARCHAR(50),
								regdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
								friends VARCHAR(50)
								)';
if (mysqli_query($conn, $sql_createtbl)) 
	echo 'Table guests created<br>';
else
	echo 'Table created error: ' . $sql_createtbl ."<br>". mysqli_error($conn);

$stmt = mysqli_prepare($conn, "INSERT INTO guests (firstname, lastname, email) VALUES(?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $firstname, $lastname, $email);

$firstname = "Firstname7";
$lastname = "Lastname7";
$email = "mail7@example.com";
mysqli_stmt_execute($stmt);
$firstname = "Firstname8";
$lastname = "Lastname8";
$email = "mail8@example.com";
mysqli_stmt_execute($stmt);
$firstname = "Firstaname9";
$lastname = "Lastname9";
$email = "mail9@example.com";
mysqli_stmt_execute($stmt);

echo "New data created<br>";

$sql = "SELECT id, firstname, lastname FROM guests";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
	}
}
else {
	echo "0 results";
}

$sql = "DELETE FROM guests WHERE id=3";
if (mysqli_query($conn, $sql)) {
	echo "Record deleted successfully";
}
else {
	echo "Error deleting record: " . mysqli_error($conn);
}

$sql = "UPDATE guests SET lastname='Doe' WHERE id=2";
if (mysqli_query($conn, $sql)) {
	echo "Record updated successfully";
}
else {
	echo "Error updating record: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>