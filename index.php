<?php
require 'dbpdomysql.php';

/* PDO */
$conn = (new dbpdomysql_connect())->connect();

$db = new dbpdomysql($conn);

$db->createtbl('users');

$fields['firstname'] = "Firstname";
$fields['lastname'] = "Lastname";
$fields['email'] = "mail@example.com";
$fields['friends'] = "2,3";
//$db->insertdata('users', $fields);

$fields['firstname'] = "Firstname2";
$fields['lastname'] = "Lastname2";
$fields['email'] = "mail2@example.com";
$fields['friends'] = "1";
//$db->insertdata('users', $fields);

$fields['firstname'] = "Firstname3";
$fields['lastname'] = "Lastname3";
$fields['email'] = "mail3@example.com";
$fields['friends'] = "1";
//$db->insertdata('users', $fields);

$users = $db->getdata('users', null);
include 'hindex.html';
?>