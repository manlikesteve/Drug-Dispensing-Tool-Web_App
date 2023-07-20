<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabib Health - Pharmacist</title>
    <link rel="stylesheet" type="text/css" href="css/view_drug.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="navbar">
    <img class="logo" src="images/_Pngtree_medical_health_logo_4135858-removebg-preview.png" alt="Logo">
    <ul>
        <li><a href="index.php">Tabib Health - Pharmacy</a></li>
        <li><a href="#">Pharmacist Dashboard</a></li>
    </ul>
    <div class="auth-buttons">
        <?php
        if (isset($_SESSION['username'])) {
            // User is logged in, display user details and logout button
            echo '<div class="user-info">';
            if (isset($_SESSION['profile_picture'])) {
                // Display the profile picture if available
                echo '<img src="' . $targetDirectory . $_SESSION['profile_picture'] . '" alt="Profile Picture" class="profile-picture">';
            } else {
                // Display a default profile picture if no picture is available
                echo '<img src="images/blank-profile-picture-973460_1280.webp" alt="Default Profile Picture" class="profile-picture">';
            }
            echo '<span>Welcome, ' . $_SESSION['username'] . '</span>
            <span class="account-type">(' . $_SESSION['userType'] . ')</span>
            <a class="logout-btn" href="logout.php">Logout</a>
        </div>';
        } else {
            // User is not logged in, display login and signup buttons
            echo '<button class="login-btn" onclick="location.href=\'login.php\'">Login</button>
            <button class="signup-btn" onclick="location.href=\'signup.php\'">Sign Up</button>';
        }
        ?>
    </div>
</div>

<div class="drug-table">
    <?php
    // Check if session variable exists
    if (isset($_SESSION['success_message'])) {
        // Display success message
        echo "<script>alert('{$_SESSION['success_message']}')</script>";

        // Unset the session variable
        unset($_SESSION['success_message']);
    }

    require_once 'connection.php';

    // Fetch total number of drugs
    $sqlCount = "SELECT COUNT(*) AS total FROM Drugs";
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
    $sql = "SELECT * FROM Drugs LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $startIndex, $patientsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <h1>Drugs Stock List</h1>

    <!-- Add patient button -->
    <a class="add-button" href="drug_form.php">Add New Drug</a>

    <?php
    // Display success message from the registration form if available
    if (isset($_GET['success'])) {
        echo "<p>Drug added successfully!</p>";
    }

    // Display table of Drugs
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Drug ID</th><th>Drug Name</th><th>Drug Description</th><th>Drug Manufacturer</th><th>Date/Time Added</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["drugid"] . "</td>";
            echo "<td>" . $row["drugname"] . "</td>";
            echo "<td>" . $row["drugdesc"] . "</td>";
            echo "<td>" . $row["drugmanufact"] . "</td>";
            echo "<td>" . $row["reg_date"] . "</td>";
            echo "<td>";
            echo "<a class='edit-button' href='edit_drug.php?id=" . $row['id'] . "'>Edit</a>";
            echo "<a class='delete-button' href='delete_drug.php?id=" . $row['id'] . "'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Display pagination links
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo "<a class='active-page' href='view_drug.php?page=" . $i . "'>" . $i . "</a>";
            } else {
                echo "<a href='view_drug.php?page=" . $i . "'>" . $i . "</a>";
            }
        }
        echo "</div>";
    } else {
        echo "<p>No drugs found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
</div>

</body>
</html>
