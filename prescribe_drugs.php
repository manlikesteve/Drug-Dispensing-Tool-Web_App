<!DOCTYPE html>
<html>
<head>
    <title>Prescribe Drugs</title>
    <link rel="stylesheet" href="css/prescribe_drugs.css">
    <style>
        /* CSS styles for the prescribe_drugs.php page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Set the height to the full viewport height */
            text-align: center; /* Centering the content */
        }

        .prescription-container {
            margin-left: 200%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .patient-info,
        .prescribe-drug-form {
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Other styles... */

        /* Styling for the patient information section */
        .patient-info {
            background-color: #f9f9f9;
        }

        h1 {
            font-family: Chalkduster;
            color: #005000;
            text-align: center; /* Centering the content */
        }

        h2 {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            text-align: left; /* Aligning left for the patient info */
        }

        p {
            margin: 5px 0;
        }

        form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: left; /* Aligning left for the patient info */
        }

        form select,
        form input[type="text"] {
            width: 90%; /* Take up the full width of the form container */
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        form button[type="submit"],
        form button.cancel-button {
            width: 49%; /* Equal width for both buttons */
            background-color: #005000;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        form button[type="submit"]:hover,
        form button.cancel-button:hover {
            background-color: #003300;
        }

        /* Styling for the patient information section */
        .patient-info {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .patient-info h2 {
            margin-top: 0;
            text-align: center; /* Centering the patient info title */
        }

        /* Styling for error and success messages */
        .error-message {
            color: #f44336;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .success-message {
            color: #005000;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php
session_start();

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the prescription form submission

    // Validate form data
    $patient_id = $_GET['patient_id'];
    $drug_name = $_POST['drug'];
    $dosage = $_POST['dosage'];
    $duration = $_POST['duration'];

    // Get the prescribing doctor's username from the session
    $prescribing_doctor = $_SESSION['username'];

    // Insert prescription data into the database
    $prescription_date = date("Y-m-d"); // Get the current date

    $sql = "INSERT INTO prescriptions (patient_id, drug_name, dosage, duration, prescribing_doctor, prescription_date)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $patient_id, $drug_name, $dosage, $duration, $prescribing_doctor, $prescription_date);

    if ($stmt->execute()) {
        // Set success message and redirect back to the doctor dashboard
        $_SESSION['success_message'] = "Prescription added successfully!";
        header("Location: doctor_dashboard.php");
        exit();
    } else {
        // If the query fails, display an error message
        echo "<p class='error-message'>Failed to add prescription. Please try again.</p>";
    }
}

// Check if a patient ID is provided in the URL
if (isset($_GET['patient_id']) && !empty($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];

    // Fetch patient information from the database based on the patient ID
    $sql = "SELECT * FROM patients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        echo "<p class='error-message'>Patient not found.</p>";
        exit();
    }
} else {
    echo "<p class='error-message'>Patient ID not provided.</p>";
    exit();
}

// Fetch drugs from the database for the drugs stock list
$sqlDrugs = "SELECT * FROM drugs";
$resultDrugs = $conn->query($sqlDrugs);

?>


<div class="prescription-container">
    <h1>Prescribe Drugs</h1><br>
    <!-- Patient Information Section (Centered) -->
    <div class="patient-info">
        <h2>Patient Information</h2>
        <p><strong>Patient ID:</strong> <?php echo $patient['id']; ?></p>
        <p><strong>Name:</strong> <?php echo $patient['firstname'] . ' ' . $patient['lastname']; ?></p>
        <p><strong>Email:</strong> <?php echo $patient['email']; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $patient['phone_number']; ?></p>
        <p><strong>Registration Date/Time:</strong> <?php echo $patient['reg_date']; ?></p>
    </div>

    <!-- Prescription Form -->
    <form method="post" action="prescribe_drugs.php?patient_id=<?php echo $patient_id; ?>">
        <h2>Prescription Details</h2>

        <label for="drug">Select Drug:</label>
        <select id="drug" name="drug" required>
            <option value="" disabled selected>Select a drug</option>
            <?php while ($row = $resultDrugs->fetch_assoc()) : ?>
                <option value="<?php echo $row['drugname']; ?>"><?php echo $row['drugname']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="dosage">Dosage:</label>
        <input type="text" id="dosage" name="dosage" required>

        <label for="duration">Duration (Days):</label>
        <input type="text" id="duration" name="duration" required>

        <button type="submit">Prescribe</button>
        <button type="button" class="cancel-button" onclick="window.location='doctor_dashboard.php'">Cancel</button>
    </form>
</div>

<!-- Error and Success Messages -->
<?php
if (isset($_GET['error_message'])) {
    echo "<p class='error-message'>{$_GET['error_message']}</p>";
}

if (isset($_GET['success_message'])) {
    echo "<p class='success-message'>{$_GET['success_message']}</p>";
}

?>

</body>
</html>