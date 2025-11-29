<?php
include 'config.php';

$errors = [];
// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Collect and sanitize form inputs
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm  = trim($_POST["confirm"]);
// Validate required fields
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $errors[] = "All fields are required.";
    }
// Check if both password fields match
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }
// Check if email already exists in the database
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email is already registered.";
    }
// If no errors, proceed with account creation
    if (count($errors) === 0) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
// Insert new user into the database
        $sql = "INSERT INTO users (name, email, password)
                VALUES ('$name', '$email', '$hashed')";

        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?registered=1");// Redirect to login page with success message
            exit();
        } else {
            $errors[] = "An error occurred during registration.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style4.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- ============================
     PAGE WRAPPER
============================= -->
<div class=login-page>
<div class="auth-box">
    <!-- Page Heading -->
    <h2>Create Account</h2>

    <?php
    if (!empty($errors)) {
        echo "<div class='error'>";
        foreach ($errors as $e) echo "<p>$e</p>";  // Loop to display each error message
        echo "</div>";
    }
    ?>
    <!-- ============================
         REGISTRATION FORM
    ============================= -->
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name">
        <input type="email" name="email" placeholder="Email Address">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="confirm" placeholder="Confirm Password">
        <button type="submit">Register</button>
    </form>
  <!-- Link to Login Page -->
    <div class="link">
        Already have an account? <a href="index.php">Login here</a>
    </div>
</div>
</div>

</body>
</html>
