<?php
require_once 'connection.php';

// Check if ID parameter is provided
if (isset($_GET['id'])) {
    $drugId = $_GET['id'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("SELECT * FROM Drugs WHERE id = ?");
    $stmt->bind_param("i", $drugId);

    // Execute the SQL statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if patient exists
    if ($result->num_rows > 0) {
        $drug = $result->fetch_assoc();
        $drugid = $drug['drugid'];
        $drugname = $drug['drugname'];
    } else {
        echo "Drug not found.";
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
        $stmt = $conn->prepare("DELETE FROM Drugs WHERE id = ?");
        $stmt->bind_param("i", $drugId);

        // Execute the SQL statement
        if ($stmt->execute()) {
            $successMessage = "Drug deleted successfully!";
            echo "<script>alert('$successMessage'); window.location.href = 'view_drug.php';</script>";
        } else {
            echo "Error deleting drug: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // User canceled the deletion
        echo "<script>window.location.href = 'pharmacist_dashboard.php';</script>";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Drug</title>
    <link rel="stylesheet" href="css/delete_patient.css">
</head>
<body>
<div class="card">
    <h1>Delete Drrug</h1>
    <p>Are you sure you want to delete the patient:</p>
    <p><?php echo $drugid . ' ' . $drugname; ?></p>
    <div class="button-container">
        <form method="POST" action="">
            <button class="confirm-button" type="submit" name="confirm_delete">Confirm Delete</button>
            <button class="cancel-button" type="submit" name="cancel_delete">Cancel</button>
        </form>
    </div>
</div>
</body>
</html>