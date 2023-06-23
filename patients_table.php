<!DOCTYPE html>
<html>
<head>
    <title>Registered Patients</title>
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

        .pagination {
            margin-top: 10px;
        }

        .pagination a {
            color: #4CAF50;
            background-color: transparent;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 5px;
        }

        .pagination a.active-page {
            color: #fff;
            background-color: #4CAF50;
        }

        .pagination a:hover {
            background-color: #45a049;
            color: #f1f1f1;
        }

        .edit-button, .delete-button {
            background-color: #2196f3;
            border: none;
            color: white;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }

        .delete-button {
            background-color: #f44336;
        }

        .add-button {
            background-color: #45a049;
            border: none;
            color: white;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php
require_once 'connection.php';

// Fetch total number of patients
$sqlCount = "SELECT COUNT(*) AS total FROM patients";
$resultCount = $conn->query($sqlCount);
$totalPatients = $resultCount->fetch_assoc()['total'];

// Define how many patients to display per page
$patientsPerPage = 10;

// Calculate the total number of pages
$totalPages = ceil($totalPatients / $patientsPerPage);

// Determine the current page
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

// Calculate the starting patient index for the current page
$startIndex = ($currentPage - 1) * $patientsPerPage;

// Fetch patient records for the current page
$sql = "SELECT * FROM patients LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $startIndex, $patientsPerPage);
$stmt->execute();
$result = $stmt->get_result();
?>

<h1>Registered Patients List</h1>

<!-- Add patient button -->
<a class="add-button" href="patient_form.php">Add New Patient</a>

<?php
// Display success message from the registration form if available
if (isset($_GET['success'])) {
    echo "<p>Patient registered successfully!</p>";
}

// Display table of patients
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>Registration Date/Time</th><th>Actions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["firstname"] . "</td>";
        echo "<td>" . $row["lastname"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["phone_number"] . "</td>";
        echo "<td>" . $row["reg_date"] . "</td>";
        echo "<td>";
        echo "<a class='edit-button' href='edit_patient.php?id=" . $row['id'] . "'>Edit</a>";
        echo "<a class='delete-button' href='delete_patient.php?id=" . $row['id'] . "'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Display pagination links
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            echo "<a class='active-page' href='patients_table.php?page=" . $i . "'>" . $i . "</a>";
        } else {
            echo "<a href='patients_table.php?page=" . $i . "'>" . $i . "</a>";
        }
    }
    echo "</div>";
} else {
    echo "<p>No patients found.</p>";
}

// Close the database connection
$conn->close();
?>
</body>
</html>