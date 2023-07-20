<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabib Health - Patient</title>
    <link rel="stylesheet" type="text/css" href="css/patient_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        .main-content {
            padding: 20px;
            margin-top: 100px;
        }

        .welcome-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;

            /* Set the background image */
            background-image: url("images/Lafarmacia_ Centro Milano _ AMlab.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            z-index: 1; /* Set z-index to 1 to place it above the overlay */
        }

        #welcome-background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 80, 0, 0.5); /* Set the background color with 50% transparency */
            z-index: 2; /* Set z-index to 2 to place it above the background image but behind the content */
        }

        .welcome-section .text {
            flex: 1;
            margin-right: 20px;
            position: relative; /* Add position relative to the text content */
            z-index: 3; /* Set z-index to 3 to place it above the overlay and background image */
        }

        .welcome-section h2 {
            font-size: 72px;
            margin-bottom: 10px;
            color: #ffffff;
            font-family: Chalkduster;
        }

        .welcome-section p {
            font-size: 24px;
            color: #ffffff;
            margin-bottom: 10px;
            font-family: "Telugu MN";
        }

        .welcome-section .image {
            flex: 1;
            text-align: center;
            position: relative; /* Add position relative to the image content */
            z-index: 3; /* Set z-index to 3 to place it above the overlay and background image */
        }

        .welcome-section .image img {
            width: 100%;
            max-width: 500px;
            height: auto;
            max-height: 500px;
            border-radius: 5px;
        }

        .get-started-btn {
            display: inline-block;
            background-color: #ffffff;
            color: #005000;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            margin-top: 20px;
            font-family: "Telugu MN";
        }

        .get-started-btn:hover {
            background-color: #005000;
            color: white;
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
    </style>
</head>
<body>

<div class="navbar">
    <img class="logo" src="images/_Pngtree_medical_health_logo_4135858-removebg-preview.png" alt="Logo">
    <ul>
        <li><a href="index.php">Tabib Health - Home</a></li>
        <li><a href="#">Patient Dashboard</a></li>
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

<div class="main-content" id="welcome">
    <div class="welcome-section">
        <div class="text">
            <h2>We Are <br> Tabib Health</h2>
            <p>A Drug Dispensing Tool <br> designed to help patients, doctors, and pharmacists
                <br> manage prescriptions, medications, and medical records efficiently and securely.</p>
            <a href="signup.php" class="get-started-btn">View your Prescriptions</a>
        </div>
        <div class="image">
            <img src="images/pngtree-online-medical-health-consultation-doctor-vector-illustration-pattern-element-png-image_5779867-removebg-preview.png" alt="Image 1">
        </div>
        <div id="welcome-background-overlay"></div>
    </div>
</div>

</body></html>