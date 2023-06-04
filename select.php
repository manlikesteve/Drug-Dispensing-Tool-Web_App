<?php
require_once ('connection.php');


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Start";
$sql = "SELECT * FROM Patients";
$result = $conn->query($sql);
echo "<br>";
print_r($result);
echo "<br>";
//print_r($row = $result -> fetch_assoc());
echo "<br>";

if ($result -> num_rows > 0){
    // output data of each row
    while ($row = $result -> fetch_assoc()){
        echo "First Name: " . $row["firstname"] . " Last Name: " . $row["lastname"] . " Email: " . $row["email"] . " Phone Number: " . $row["phone_number"] . " Registration Date: " . $row["reg_date"] . "<br>";
    }
}else {
    echo "0 results";
}
