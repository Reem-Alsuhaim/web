<?php
session_start();
include 'config.php';

// default error
$error = "";

// handle login form
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // get form inputs
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

    // validate inputs
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";

    } else {

        // check email in database
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        // email found
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            // verify password
            if (!empty($row["password"]) && password_verify($password, $row["password"])) {

                // store session data
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name']    = $row['name'];

                header("Location: home.php");
                exit();

            } else {
                $error = "Wrong password.";
            }

        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Event Booking System</title>

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

    <!-- page title -->
    <h2 style="text-align:center;">Login</h2>

    <?php
    // success message after registration
    if (isset($_GET["registered"])) {
        echo "<div class='success'>Account created successfully. You can now login.</div>";
    }

    // user tried accessing a protected page
    if (isset($_GET["login_required"])) {
        echo "<div class='error'>Please login to continue.</div>";
    }

    // login errors
    if (!empty($error)) {
        echo "<div class='error'>$error</div>";
    }
    ?>

    <!-- login form -->
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email Address">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>

    <!-- register link -->
    <div class="link">
        Not a member? <a href="register.php">Create an account</a>
    </div>

</div>
</div>

</body>
</html>

