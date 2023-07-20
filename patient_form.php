<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration Form</title>
    <link rel="stylesheet" href="css/patient_form.css">
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'connection.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $timestamp = $_POST["timestamp"];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO Patients (firstname, lastname, email, phone_number, reg_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $phone, $timestamp);

    // Execute the SQL statement
    if ($stmt->execute()) {
        $successMessage = "Patient registered successfully!";
        $linkToPatientList = '<a href="doctor_dashboard.php">View Patient List</a>'; // Link to doctor_dashboard.php
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

<div class="card">
    <h1>Patient Registration</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required><br><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required><br><br>

        <input type="hidden" name="timestamp" value="<?php echo date('Y-m-d H:i:s'); ?>">

        <button type="submit">Register</button>
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
