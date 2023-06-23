<?php
session_start();
require_once 'connection.php';

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    // User is already logged in, redirect to index page
    header("Location: index.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the user exists in the database
    // Perform necessary database query and validation here
    // Assuming you have already established a database connection ($conn)

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

            // Redirect to index page after successful login
            header("Location: index.php");
            exit;
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
    <title>Drug Dispensing Tool - Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }

        .card {
            width: 300px;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            text-align: center;
            color: #333333;
        }

        .card input[type="text"],
        .card input[type="password"],
        .card select {
            width: 100%;
            padding: 10px;
            margin: auto;
            display: block;
            border: none;
            border-radius: 5px;
            background-color: #ffffff;
            text-align: center;
            box-sizing: border-box;
        }

        .card button {
            display: block;
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: none;
            background-color: green;
            color: #fff;
            font-weight: bold;
        }

        .card button:hover {
            background-color: darkgreen;
        }

        .card a {
            color: #4caf50;
            text-decoration: none;
        }
    </style>
</head>
<body>
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
