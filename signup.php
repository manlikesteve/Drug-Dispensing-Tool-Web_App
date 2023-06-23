<?php
require_once 'connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['user_type'];
    $haveAccount = isset($_POST['have_account']);

    if ($haveAccount) {
        // Redirect to the login page
        header("Location: login.php");
        exit();
    } else {
        // Check if the username already exists in the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username already exists";
        } else {
            // Insert the new user into the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashedPassword, $userType);
            $stmt->execute();

            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['userType'] = $userType;

            // Redirect to the landing page
            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
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

        .card h1 {
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
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4caf50;
            color: #ffffff;
            cursor: pointer;
        }

        .card button:hover {
            background-color: #45a049;
        }

        .card a {
            color: #4caf50;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="card">
    <h1>Sign Up</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="text" id="username" name="username" placeholder="Create a Username" required><br>

        <input type="password" id="password" name="password" placeholder="Create a Password" required><br>

<!--        <label for="user_type">User Type:</label>-->
        <select id="user_type" name="user_type" required>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
            <option value="pharmacist">Pharmacist</option>
        </select><br><br>

        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>