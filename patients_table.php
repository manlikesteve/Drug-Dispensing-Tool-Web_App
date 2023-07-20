<!DOCTYPE html>
<html>
<head>
    <title>Registered Patients</title>
    <link rel="stylesheet" href="css/patients_table.css">
    <style>
        /* CSS styles for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        h1 {
            font-family: Chalkduster;
            color: #005000;
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
            color: #005000;
            background-color: transparent;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 5px;
        }

        .pagination a.active-page {
            color: #fff;
            background-color: #005000;
        }

        .pagination a:hover {
            background-color: #005000;
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

        /* CSS styles for the search form and button positioning */
        form {
            display: inline-block;
            margin-left: 10px;
        }

        input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #005000;
            border: none;
            color: white;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-button {
            background-color: #005000;
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
            float: right;
            margin-right: 10px;
        }

        .prescribe-button {
            background-color: #005000;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
<?php
session_start();

// Check if session variable exists
if (isset($_SESSION['success_message'])) {
    // Display success message
    echo "<script>alert('{$_SESSION['success_message']}')</script>";

    // Unset the session variable
    unset($_SESSION['success_message']);
}

require_once 'connection.php';

// Fetch total number of patients
$sqlCount = "SELECT COUNT(*) AS total FROM patients";
$resultCount = $conn->query($sqlCount);
$totalPatients = $resultCount->fetch_assoc()['total'];

// Define how many patients to display per page
$patientsPerPage = 8;

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


// Fetch patient records for the current page
if (isset($_GET['search']) && !empty($_GET['search'])) {
    // If search query is provided, filter patients based on the search term
    $search = "%" . $_GET['search'] . "%";
    $sql = "SELECT * FROM patients WHERE firstname LIKE ? OR lastname LIKE ? LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $search, $search, $startIndex, $patientsPerPage);
} else {
    // If no search query, fetch all patients for the current page
    $sql = "SELECT * FROM patients LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $startIndex, $patientsPerPage);
}

$stmt->execute();
$result = $stmt->get_result();


?>

<h1>Registered Patients List</h1>

<!-- Search form -->
<form method="GET" action="doctor_dashboard.php">
    <input type="text" name="search" placeholder="Search by First Name or Last Name">
    <button type="submit">Search</button>
</form>

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
        echo "<a class='prescribe-button' href='prescribe_drugs.php?patient_id=" . $row['id'] . "'>Prescribe</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Display pagination links
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            echo "<a class='active-page' href='doctor_dashboard.php?page=" . $i . "'>" . $i . "</a>";
        } else {
            echo "<a href='doctor_dashboard.php?page=" . $i . "'>" . $i . "</a>";
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