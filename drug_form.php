<!DOCTYPE html>
<html>
<head>
    <title>Drug Input Form</title>
    <link rel="stylesheet" href="css/drug_form.css">
</head>
<body>

<div class="navbar">
    <img class="logo" src="images/_Pngtree_medical_health_logo_4135858-removebg-preview.png" alt="Logo">
    <ul>
        <li><a href="index.php">Tabib Health - Home</a></li>
        <li><a href="#">Doctor Dashboard</a></li>
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

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $drugid = $_POST["drugid"];
    $drugname = $_POST["drugname"];
    $drugdesc = $_POST["drugdesc"];
    $drugmanufact = $_POST["drugmanufact"];
    $timestamp = $_POST["timestamp"];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO Drugs (drugid, drugname, drugdesc, drugmanufact, reg_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $drugid, $drugname, $drugdesc, $drugmanufact, $timestamp);

    // Execute the SQL statement
    if ($stmt->execute()) {
        $successMessage = "Drug added successfully!";
        $linkToPatientList = '<a href="pharmacist_dashboard.php">View Drug Stock List</a>'; // Link to view_drug.php
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

<div class="card">
    <h1>Drug Stock</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="drugid">Drug ID:</label>
        <input type="text" id="drugid" name="drugid" required><br><br>

        <label for="drugname">Drug Name</label>
        <input type="text" id="drugname" name="drugname" required><br><br>

        <label for="drugdesc">Drug Description:</label>
        <input type="text" id="drugdesc" name="drugdesc" required><br><br>

        <label for="drugmanufact">Drug Manufacturer:</label>
        <input type="text" id="drugmanufact" name="drugmanufact" required><br><br>

        <input type="hidden" name="timestamp" value="<?php echo date('Y-m-d H:i:s'); ?>">

        <button type="submit">Add Drug</button>
        <?php if (!empty($successMessage)) { ?>
            <div class="success-message">
                <?php echo $successMessage; ?>
                <?php echo $linkToPatientList; ?>
            </div>
        <?php } ?>
    </form>
</div>
</body>
</html>
