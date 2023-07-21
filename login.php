<?php
session_start();
require_once 'connection.php';

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // Redirect based on user type
    if ($_SESSION['userType'] === 'doctor') {
        header("Location: doctor_dashboard.php");
    } elseif ($_SESSION['userType'] === 'patient') {
        header("Location: index.php");
    } elseif ($_SESSION['userType'] === 'pharmacist') {
        header("Location: pharmacist_dashboard.php");
    }
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the submitted credentials are for the admin user
    if ($username === "admin" && $password === "admin1") {
        // Admin credentials are valid, set the session variable
        $_SESSION["admin_logged_in"] = true;

        // Redirect the admin to the admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    }

    // Prepare the SQL statement to fetch user details based on the username
    $stmt = $conn->prepare("SELECT username, password, user_type FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the user exists in the database
    if ($result->num_rows > 0) {
        // User exists, fetch the user details
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['userType'] = $row['user_type'];
            $_SESSION['profile_picture'] = $row['profile_picture'];

            // Redirect based on user type
            if ($row['user_type'] === 'doctor') {
                header("Location: doctor_dashboard.php");
            } elseif ($row['user_type'] === 'patient') {
                header("Location: patient_dashboard.php");
            } elseif ($row['user_type'] === 'pharmacist') {
                header("Location: pharmacist_dashboard.php");
            }
            exit();
        } else {
            // Password is incorrect, display an error message
            $error = "Invalid password";
        }
    } else {
        // User does not exist, display an error message
        $error = "User not found";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabib Health - Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<div class="navbar">
    <img class="logo" src="images/_Pngtree_medical_health_logo_4135858-removebg-preview.png" alt="Logo">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php">About Us</a></li>
        <li><a href="index.php">Services</a></li>
        <li><a href="index.php">Contact</a></li>
    </ul>
    <ul>
        <li><a class="login-btn active" href="login.php">Login</a></li>
        <li><a class="signup-btn" href="signup.php">Sign up</a></li>
    </ul>
</div>

<div class="card">
    <h2>Login</h2>
    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <p>Not registered? <a href="signup.php">Sign up</a></p>
</div>
</body>
</html>
