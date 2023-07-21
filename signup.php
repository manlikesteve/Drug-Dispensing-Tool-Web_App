<?php
require_once 'connection.php';

// Directory to store profile pictures
$targetDirectory = "profile_pictures/";

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

            // Check if a profile picture is uploaded
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                $profilePicture = $_FILES['profile_picture'];
                $filename = basename($profilePicture['name']);
                $targetPath = $targetDirectory . $filename;

                // Check if the uploaded file is an image
                $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
                $allowedExtensions = array("jpg", "jpeg", "png", "gif");
                if (!in_array($imageFileType, $allowedExtensions)) {
                    $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
                } else {
                    if (move_uploaded_file($profilePicture['tmp_name'], $targetPath)) {
                        $profilePicturePath = $filename;

                        // Save the profile picture path in session
                        $_SESSION['profile_picture'] = $filename;
                    } else {
                        $error = "Error uploading profile picture.";
                    }
                }
            } else {
                // No profile picture uploaded, use default picture
                $profilePicturePath = $defaultPicture;
            }

            if (!isset($error)) {
                $stmt = $conn->prepare("INSERT INTO users (username, password, user_type, profile_picture) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $username, $hashedPassword, $userType, $profilePicturePath);
                $stmt->execute();

                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['userType'] = $userType;

                // Redirect based on user type
                if ($userType === 'doctor') {
                    header("Location: doctor_dashboard.php");
                } elseif ($userType === 'patient') {
                    header("Location: patient_dashboard.php");
                } elseif ($userType === 'pharmacist') {
                    header("Location: pharmacist_dashboard.php");
                }
                exit();
            }
        }
    }
}
?>

<!-- Remaining HTML code -->

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="css/signup.css">
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
        <li><a class="login-btn" href="login.php">Login</a></li>
        <li><a class="signup-btn active" href="signup.php">Sign up</a></li>
    </ul>
</div>

<!--Sign Up Form-->
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

        <label for="profile_picture">Profile Picture: <br> (Only JPG, JPEG, PNG, and GIF files)<br> <br></label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required><br><br>

        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>