<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration Form</title>
    <style>
        /* CSS styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        .card {
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .success-message {
            text-align: center;
            margin-top: 10px;
            color: green;
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
        $linkToPatientList = '<a href="patients_table.php">View Patient List</a>'; // Link to patients_table.php
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
