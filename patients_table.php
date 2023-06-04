<!DOCTYPE html>
<html>
<head>
    <title>Patient Table</title>
    <style>
        /* CSS styles for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
require_once 'connection.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all patient records
$sql = "SELECT * FROM patients";
$result = $conn->query($sql);
?>

<h1>List of Patients</h1>
<?php
// Display success message from the registration form if available
if (isset($_GET['success'])) {
    echo "<p>Patient registered successfully!</p>";
}

// Display table of patients
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>Registration Date/Time</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["firstname"] . "</td>";
        echo "<td>" . $row["lastname"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["phone_number"] . "</td>";
        echo "<td>" . $row["reg_date"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No patients found.</p>";
}

// Close the database connection
$conn->close();
?>
</body>
</html>
