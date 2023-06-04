<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
<h2>Registration Form</h2>

<form action="select.php" method="POST">
    <label for="firstname">First Name:</label>
    <input type="text" name="firstname" id="firstname" required><br><br>

    <label for="lastname">Last Name:</label>
    <input type="text" name="lastname" id="lastname" required><br><br>

    <label for="email"> Email:</label>
    <input type="email" name="email" id="email" required><br><br>

    <label for="phone_number">Phone Number:</label>
    <input type="number" name="phone_number" id="phone_number" required><br><br>

    <input type="submit" value="Register">
</form>
</body>
</html>