<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "bus";

// Create connection
$con = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
