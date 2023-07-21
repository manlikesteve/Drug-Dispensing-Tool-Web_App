<?php
session_start();

// Function to format date and time
function formatDateTime($datetime) {
    return date('M d, Y - h:i A', strtotime($datetime));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabib Health - Dispensed Drugs</title>
    <link rel="stylesheet" type="text/css" href="css/dispense_drugs.css">
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

<div class="dispensing-history">
    <?php
    require_once 'connection.php';

    // Fetch all dispensed drugs from drug_dispensing_history
    $sql = "SELECT * FROM drug_dispensing_history";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h1>Drug Dispensing History</h1><br>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Prescription ID</th><th>Drug Name</th><th>Patient Name</th><th>Dispensing Date</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["prescription_id"] . "</td>";
            echo "<td>" . $row["drug_name"] . "</td>";
            echo "<td>" . $row["patient_name"] . "</td>";
            echo "<td>" . formatDateTime($row["dispensing_date"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h1>Drug Dispensing History</h1>"; // Add title even if no dispenses found
        echo "<p>No dispensed drugs found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
</div>

<div class="cancel-button">
    <button onclick="location.href='pharmacist_dashboard.php'">Back to Dashboard</button>
</div>

<!-- Add any additional HTML or scripts here if needed -->

</body>
</html>