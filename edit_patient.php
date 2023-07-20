<?php
require_once 'connection.php';

// Check if ID parameter is provided
if (isset($_GET['id'])) {
    $patientId = $_GET['id'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("SELECT * FROM Patients WHERE id = ?");
    $stmt->bind_param("i", $patientId);

    // Execute the SQL statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if patient exists
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        $firstname = $patient['firstname'];
        $lastname = $patient['lastname'];
        $email = $patient['email'];
        $phone = $patient['phone_number'];
    } else {
        echo "Patient not found.";
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request.";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if cancel button is clicked
    if (isset($_POST['cancel'])) {
        // Redirect back to the patient table
        header("Location: doctor_dashboard.php");
        exit();
    }

    // Perform the update operation
    $newFirstname = $_POST['firstname'];
    $newLastname = $_POST['lastname'];
    $newEmail = $_POST['email'];
    $newPhone = $_POST['phone'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("UPDATE patients SET firstname = ?, lastname = ?, email = ?, phone_number = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $newFirstname, $newLastname, $newEmail, $newPhone, $patientId);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Set session variable for success message
        $_SESSION['success_message'] = 'Patient details have been updated successfully!';
    } else {
        echo "Error updating patient data: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Patient</title>
    <link rel="stylesheet" href="css/edit_patient.css">
</head>
<body>
<div class="card">
    <h1>Edit Patient</h1>
    <form method="POST" action="edit_patient.php?id=<?php echo $patientId; ?>">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" required><br><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required><br><br>

        <div class="button-container">
            <button class="submit-button" type="submit" name="submit">Update</button>
            <button class="cancel-button" type="submit" name="cancel">Cancel</button>
        </div>
    </form>
</div>

<script>
    // Check if the session variable for success message is set
    <?php if (isset($_SESSION['success_message'])): ?>
    // Display success message
    alert('<?php echo $_SESSION['success_message']; ?>');
    // Redirect back to the patient table
    window.location.href = 'doctor_dashboard.php';
    // Unset the session variable
    <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
</script>

</body>
</html>
