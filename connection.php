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

// Create database
//$sql = "CREATE DATABASE DrugDispensingTool";
//if ($conn->query($sql) === TRUE) {
//    echo "Database created successfully";
//} else {
//    echo "Error creating database: " . $conn->error;
//}

// sql to Create Table
//$sql = "CREATE TABLE Patients (
//    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//    firstname VARCHAR(30) NOT NULL,
//    lastname VARCHAR(30) NOT NULL,
//    email VARCHAR(50),
//    phone_number INT(10),
//    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
//)";

//if($conn->query($sql) === TRUE){
//    echo "Table Patients created successfully";
//} else {
//    echo "Error creating  table: " . $conn->error;
//}

$conn->close();