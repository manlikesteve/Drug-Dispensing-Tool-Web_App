<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Drug Dispensing Tool</title>
    <style>
        /* CSS styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #005000;
            padding: 10px;
            border-radius: 5px;
        }
        .navbar ul {
            list-style: none;
            display: flex;
        }
        .navbar ul li {
            margin-right: 10px;
        }
        .navbar ul li a {
            text-decoration: none;
            color: #ffffff;
            font-family: "American Typewriter";
        }

        .navbar .user-info {
            text-align: right;
            display: flex;
            align-items: center;
        }
        .navbar .user-info span {
            color: green;
            font-size: 14px;
            margin-right: 10px;
        }
        .navbar .user-info .account-type {
            font-size: 12px;
            color: #666;
        }
        .navbar .logout-btn {
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
        }
        .carousel {
            position: relative;
            height: 400px;
            overflow: hidden;
        }
        .carousel-slide {
            display: flex;
            width: 300%;
            animation: slide 15s infinite;
        }
        .carousel-slide img {
            width: 100%;
            height: 1000px;
            object-fit: cover;
        }
        @keyframes slide {
            0% {
                transform: translateX(0);
            }
            33.33% {
                transform: translateX(-100%);
            }
            66.66% {
                transform: translateX(-200%);
            }
            100% {
                transform: translateX(0);
            }
        }
        .carousel-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #000000;
            font-size: 24px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .user-info {
            text-align: right;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
            color: green;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="navbar">
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
    <?php
    session_start();
    if (isset($_SESSION['username'])) {
        // User is logged in, display user details and logout button
        echo '<div class="user-info">
                <span>Welcome, ' . $_SESSION['username'] . '</span>
                <span class="account-type">(' . $_SESSION['userType'] . ')</span>
                <a class="logout-btn" href="logout.php">Logout</a>
              </div>';
    } else {
        // User is not logged in, display login and signup links
        echo '<ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign up</a></li>
              </ul>';
    }
    ?>
<!--    <div class="user-info">-->
<!--        <span>Welcome, --><?php //echo $_SESSION['username']; ?><!--</span>-->
<!--        <span>--><?php //echo $_SESSION['userType']; ?><!--</span>-->
<!--        <a class="logout-btn" href="logout.php">Logout</a>-->
<!--    </div>-->
</div>

<div class="carousel">
<!--    <div class="carousel-slide">-->
<!--        <img src="images/image1.webp" alt="Image 1">-->
<!--        <img src="images/image2.jpeg" alt="Image 2">-->
<!--    </div>-->
    <div class="carousel-text">
        <h2>Welcome to our Drug Dispensing Tool</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi esse explicabo fugit iure veritatis.
            Ab assumenda deserunt, dolorum eos, eveniet hic illo incidunt neque numquam omnis quas tempore veritatis?
            Doloremque?</p>
    </div>
</div>

<!-- Rest of our landing page content -->

<script>
    // JavaScript code if needed
</script>
</body>
</html>

