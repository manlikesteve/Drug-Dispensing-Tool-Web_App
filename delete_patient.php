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

// Handle delete confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if delete confirmation is submitted
    if (isset($_POST['confirm_delete'])) {
        // Delete the patient record
        $stmt = $conn->prepare("DELETE FROM Patients WHERE id = ?");
        $stmt->bind_param("i", $patientId);

        // Execute the SQL statement
        if ($stmt->execute()) {
            $successMessage = "Patient deleted successfully!";
            echo "<script>alert('$successMessage'); window.location.href = 'patients_table.php';</script>";
        } else {
            echo "Error deleting patient: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // User canceled the deletion
        echo "<script>window.location.href = 'patients_table.php';</script>";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Patient</title>
    <style>
        /* CSS styles for the delete page */
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

        p {
            margin-top: 10px;
            text-align: center;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button-container button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            margin-right: 5px;
            cursor: pointer;
        }

        .confirm-button {
            background-color: #f44336;
            color: #fff;
        }

        .cancel-button {
            background-color: #ddd;
            color: #000;
        }
    </style>
</head>
<body>
<div class="card">
    <h1>Delete Patient</h1>
    <p>Are you sure you want to delete the patient:</p>
    <p><?php echo $firstname . ' ' . $lastname; ?></p>
    <div class="button-container">
        <form method="POST" action="">
            <button class="confirm-button" type="submit" name="confirm_delete">Confirm Delete</button>
            <button class="cancel-button" type="submit" name="cancel_delete">Cancel</button>
        </form>
    </div>
</div>
</body>
</html>