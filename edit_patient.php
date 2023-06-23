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
        header("Location: patients_table.php");
        exit();
    }

    // Perform the update operation
    // ...

    // Redirect back to the patient table after updating the data
    header("Location: patients_table.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Patient</title>
    <style>
        /* CSS styles for the edit page */
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

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            margin-right: 5px;
            cursor: pointer;
        }

        .submit-button {
            background-color: #4caf50;
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
    <h1>Edit Patient</h1>
    <form method="POST" action="">
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
</body>
</html>