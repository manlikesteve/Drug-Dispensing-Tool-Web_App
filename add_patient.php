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

$sql = "INSERT INTO Patients (firstname, lastname, email, phone_number)
VALUES ('Jack', 'Doe', 'jack@example.com', '0700112233')";

if ($conn->query($sql) === TRUE) {
    echo "<br>";
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


