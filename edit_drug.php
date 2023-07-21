<?php
require_once 'connection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        $drugdesc = $drug['drugdesc'];
        $drugmanufact = $drug['drugmanufact'];
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if cancel button is clicked
    if (isset($_POST['cancel'])) {
        // Redirect back to the patient table
        header("Location: pharmacist_dashboard.php");
        exit();
    }

    // Perform the update operation
    $newdrugid = $_POST['drugid'];
    $newdrugname = $_POST['drugname'];
    $newdrugdesc = $_POST['drugdesc'];
    $newdrugmanufact = $_POST['drugmanufact'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("UPDATE Drugs SET drugid = ?, drugname = ?, drugdesc = ?, drugmanufact = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $newdrugid, $newdrugname, $newdrugdesc, $newdrugmanufact, $drugId);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Set session variable for success message
        $_SESSION['success_message'] = 'Drug details have been updated successfully!';
    } else {
        echo "Error updating drug data: " . $stmt->error;
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
    <title>Edit Drug</title>
    <link rel="stylesheet" href="css/edit_patient.css">
</head>
<body>
<div class="card">
    <h1>Edit Drug</h1>
    <form method="POST" action="edit_drug.php?id=<?php echo $drugId; ?>">
        <label for="drugid">Drug ID:</label>
        <input type="text" id="firstname" name="drugid" value="<?php echo $drugid; ?>" required><br><br>

        <label for="drugname">Drug Name:</label>
        <input type="text" id="lastname" name="drugname" value="<?php echo $drugname; ?>" required><br><br>

        <label for="drugdesc">Drug Description:</label>
        <input type="text" id="email" name="drugdesc" value="<?php echo $drugdesc; ?>" required><br><br>

        <label for="drugmanufact">Drug Manufacturer:</label>
        <input type="text" id="phone" name="drugmanufact" value="<?php echo $drugmanufact; ?>" required><br><br>

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
    window.location.href = 'pharmacist_dashboard.php';
    // Unset the session variable
    <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
</script>

</body>
</html>