<?php
session_start();


// Function to send a message to the pharmacist upon successful dispensing
function sendDispenseMessage($drugName, $patientName) {
    echo "Drug \"$drugName\" has been successfully dispensed to patient \"$patientName\"!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabib Health - Pharmacist</title>
    <link rel="stylesheet" type="text/css" href="css/dispense_drugs.css">
    <style>
        body {
            position: relative; /* Add position relative to the body */

        &::before {
             content: '';
             position: absolute;
             top: 0;
             left: 0;
             width: 100%;
             height: 100%;
             background-color: rgb(255, 255, 255); /* Adjust the transparency value as needed (e.g., 0.5 for 50% transparency) */
             z-index: -1; /* Place the overlay behind other content */
         }
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff;
            padding: 10px;
            border-radius: 5px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 100;
        }

        .navbar .logo {
            max-height: 90px;
            width: 100%;
            max-width: 100px;
            background-color: transparent;
        }

        .navbar ul {
            list-style: none;
            display: flex;
        }

        .navbar ul li {
            position: relative; /* Position the parent list items */
            margin: 0;
        }

        .navbar .dropdown-menu {
            display: none; /* Hide the dropdown menu by default */
            position: absolute;
            top: 100%; /* Position the dropdown menu below the parent list item */
            left: 0;
            background-color: #f9f9f9;
            padding: 5px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar .dropdown-menu li {
            padding: 5px 20px;
        }

        .navbar .dropdown-menu li a {
            color: #005000;
            font-family: "American Typewriter";
            text-decoration: none;
        }

        /* Show the dropdown menu on hover */
        .navbar ul li:hover .dropdown-menu {
            display: block;
        }

        .navbar ul li a {
            text-decoration: none;
            color: #005000;
            font-family: "American Typewriter";
            position: relative;
        }

        .navbar ul li a::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #005000; /* Change the color of the line as needed */
            transition: width 0.3s ease; /* Add a smooth transition for the sliding effect */
        }

        /* Slide the line across the link on hover */
        .navbar ul li a:hover::after {
            width: 100%;
        }

        .navbar .user-info {
            text-align: right;
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .navbar .user-info span {
            color: #005000;
            font-size: 14px;
            margin-right: 10px;
        }

        .navbar .user-info .account-type {
            font-size: 12px;
            color: #666;
        }

        .login-btn{
            display: inline-block;
            background-color: #005000;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            font-family: "Telugu MN";
            margin-right: 10px; /* Add some spacing between the buttons */
            cursor: pointer;
        }

        .signup-btn {
            display: inline-block;
            background-color: #ffffff;
            color: #005000;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            font-family: "Telugu MN";
            margin-right: 40px;
            cursor: pointer;
        }

        .navbar .logout-btn {
            background-color: #005000;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
        }

        /* Add this CSS to highlight the active navbar link */
        .navbar a {
            text-decoration: none;
            color: #005000;
            font-family: "American Typewriter";
            padding: 10px 20px;
        }

        /* Add this CSS to highlight the active navbar link */
        .navbar a.active {
            border-bottom: 2px solid #005000; /* Adjust the styling as needed */
            color: #005000;
        }

        .user-info {
            text-align: right;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
            color: green;
            font-size: 14px;
            font-family: "Telugu MN";
        }

        .profile-picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        /* CSS styles for the dispense drug button */
        .prescriptions-table {
            margin-top: 120px;
        }

        h1 {
            font-family: Chalkduster;
            color: #005000;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Style the "Dispense Drug" button */
        td a.dispense-button {
            display: inline-block;
            padding: 8px 12px;
            background-color: #005000;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        td a.dispense-button:hover {
            background-color: #003300;
        }

        /* Center the Cancel button */
        .cancel-button {
            text-align: center;
            margin-top: 20px;
        }

        .cancel-button button {
            padding: 10px 20px;
            background-color: #aaa;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cancel-button button:hover {
            background-color: #999;
        }

        /* Style for the dispensing history table */
        .dispensing-history {
            margin-top: 200px;
        }

        .dispensing-history h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .dispensing-history table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        .dispensing-history th,
        .dispensing-history td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .dispensing-history th {
            background-color: #f2f2f2;
        }

        .dispensing-history tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .dispensing-history tr:hover {
            background-color: #e5f0ff;
        }
    </style>
</head>
<body>
<!-- ... (the navbar code) ... -->
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

<div class="prescriptions-table">
    <?php

    require_once 'connection.php';

    // Fetch all prescriptions with patient information
    $sql = "SELECT p.prescription_id, p.drug_name, p.dosage, p.duration, p.prescribing_doctor, p.prescription_date, 
                           pt.firstname, pt.lastname, pt.email, pt.phone_number
                    FROM prescriptions AS p
                    INNER JOIN patients AS pt ON p.patient_id = pt.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h1>All Prescriptions</h1><br>";
        echo "<table>";
        echo "<tr><th>Prescription ID</th><th>Patient Name</th><th>Email</th><th>Phone Number</th><th>Drug Name</th><th>Dosage</th><th>Duration</th><th>Prescribing Doctor</th><th>Prescription Date</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $patientName = $row["firstname"] . " " . $row["lastname"];
            echo "<tr>";
            echo "<td>" . $row["prescription_id"] . "</td>";
            echo "<td>" . $patientName . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["phone_number"] . "</td>";
            echo "<td>" . $row["drug_name"] . "</td>";
            echo "<td>" . $row["dosage"] . "</td>";
            echo "<td>" . $row["duration"] . "</td>";
            echo "<td>" . $row["prescribing_doctor"] . "</td>";
            echo "<td>" . $row["prescription_date"] . "</td>";
            // Add "Dispense Drug" button with a link to the dispense_drug.php
            echo "<td><a class ='dispense-button' href='dispense_drug.php?prescription_id=" . $row["prescription_id"] . "&drug_name=" . urlencode($row["drug_name"]) . "&patient_name=" . urlencode($patientName) . "'>Dispense Drugs</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h1>All Prescriptions</h1>"; // Add title even if no prescriptions found
        echo "<p>No prescriptions found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
</div>

<!-- Add "Cancel" button to go back to the pharmacist dashboard -->
<div class="cancel-button">
    <button onclick="location.href='pharmacist_dashboard.php'">Cancel</button>
</div>

<div class="dispensing-history">
    <?php
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
            echo "<td>" . $row["dispensing_date"] . "</td>";
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


<!-- Add any additional HTML or scripts here if needed -->

</body>
</html>