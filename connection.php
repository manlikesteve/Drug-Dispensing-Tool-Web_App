<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DrugDispensingTool";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// for debugging purposes
// echo "Connected successfully";
