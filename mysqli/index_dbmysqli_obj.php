<?php
require 'dbmysqli_obj.php';

/* MySQLi (object-oriented) */
$conn = (new dbmysqli_obj_connect())->connect();

$db = new dbmysqli_obj($conn);

$db->createtbl('users1');

$fields['firstname'] = "Firstname4";
$fields['lastname'] = "Lastname4";
$fields['email'] = "mail4@example.com";
//$db->insertdata('users1', $fields);

$fields['firstname'] = "Firstname5";
$fields['lastname'] = "Lastname5";
$fields['email'] = "mail5@example.com";
//$db->insertdata('users1', $fields);

$fields['firstname'] = "Firstname6";
$fields['lastname'] = "Lastname6";
$fields['email'] = "mail6@example.com";
//$db->insertdata('users1', $fields);

$users = $db->getdata('users1', null);
//include 'hindex_dbmysqli_obj.html';
?>