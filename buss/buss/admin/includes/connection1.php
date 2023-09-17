<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'bus';

$con = new mysqli($dbhost,$dbuser,$dbpass,$db);

//check connection
if($con->connect_error){
	die("connection failed: " . $con->connect_error);
}

?>
