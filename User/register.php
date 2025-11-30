<?php
include 'config.php';

// store errors
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // get form values
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm  = trim($_POST["confirm"]);

    // validate required fields
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $errors[] = "All fields are required.";
    }

    // check password match
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    // check duplicate email
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email is already registered.";
    }

    // insert if no errors
    if (count($errors) === 0) {

        // hash password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // insert user
        $sql = "INSERT INTO users (name, email, password)
                VALUES ('$name', '$email', '$hashed')";

        // success redirect
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?registered=1");
            exit();

        } else {

            // insert error
            $errors[] = "An error occurred during registration.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- page title -->
    <title>Register</title>

    <!-- main css -->
    <link rel="stylesheet" href="User-style.css">

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body style="
    background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
    url('/web/image/hero-bg.png') no-repeat center center fixed;
    background-size: cover;
">

<div class="login-page">
<div class="auth-box">

    <!-- logo -->
    <div style="text-align:center; margin-bottom:20px;">
        <img src="/web/image/sixflags.png" alt="Logo" style="width:160px;">
    </div>

    <!-- page heading -->
    <h2>Create Account</h2>

    <!-- show errors -->
    <?php
    if (!empty($errors)) {
        echo "<div class='error'>";
        foreach ($errors as $e) echo "<p>$e</p>";
        echo "</div>";
    }
    ?>

    <!-- register form -->
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name">
        <input type="email" name="email" placeholder="Email Address">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="confirm" placeholder="Confirm Password">
        <button type="submit">Register</button>
    </form>

    <!-- login link -->
    <div class="link">
        Already have an account? <a href="index.php">Login here</a>
    </div>

</div>
</div>

</body>
</html>

