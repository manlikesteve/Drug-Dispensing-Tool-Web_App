<?php
session_start();

require_once 'connection.php';

// Step 1: Check if the required GET parameters are set
if (isset($_GET['prescription_id']) && isset($_GET['drug_name']) && isset($_GET['patient_name'])) {
    $prescriptionId = $_GET['prescription_id'];
    $drugName = $_GET['drug_name'];
    $patientName = $_GET['patient_name'];

    // Step 2: Handle the form submission and insert data into drug_dispensing_history table
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate form data
        $dispensingDate = $_POST['dispensing_date'];

        // Insert dispensed drug data into the drug_dispensing_history table
        $sql = "INSERT INTO drug_dispensing_history (prescription_id, drug_name, patient_name, dispensing_date)
                VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $prescriptionId, $drugName, $patientName, $dispensingDate);

        if ($stmt->execute()) {
            // Set success message and redirect back to the pharmacist_dashboard
            $_SESSION['success_message'] = "Drug dispensed successfully!";
            header("Location: pharmacist_dashboard.php");
            exit();
        } else {
            // If the query fails, display an error message
            echo "<p class='error-message'>Failed to dispense drug. Please try again.</p>";
            // Uncomment the line below for debugging purposes to see the exact error message from the database
            // echo "Error: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }
    // Display the form and handle form submission
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Dispense Drug</title>
        <link rel="stylesheet" href="css/dispense_drug.css">
        <style>
            /* Add any additional CSS styles for the dispense_drug.php page here */
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Dispense Drug</h1>
            <form method="post" action="dispense_drug.php?prescription_id=' . $prescriptionId . '&drug_name=' . urlencode($drugName) . '&patient_name=' . urlencode($patientName) . '">
                <div class="form-group">
                    <label for="prescription_id">Prescription ID:</label>
                    <input type="text" id="prescription_id" name="prescription_id" value="' . $prescriptionId . '" readonly>
                </div>
                <div class="form-group">
                    <label for="drug_name">Drug Name:</label>
                    <input type="text" id="drug_name" name="drug_name" value="' . $drugName . '" readonly>
                </div>
                <div class="form-group">
                    <label for="patient_name">Patient Name:</label>
                    <input type="text" id="patient_name" name="patient_name" value="' . $patientName . '" readonly>
                </div>
                <div class="form-group">
                    <label for="dispensing_date">Dispensing Date:</label>
                    <input type="text" id="dispensing_date" name="dispensing_date" value="' . date("Y-m-d H:i:s") . '" readonly>
                </div>
                <div class="form-group">
                    <button type="submit">Dispense</button>
                    <button type="button" class="cancel-button" onclick="window.location=\'dispense_drugs.php\'">Cancel</button>
                </div>
            </form>
        </div>
    </body>
    </html>';

    // Note: You can add any additional HTML or styling to the form as needed.
}