<?php
session_start();

// Redirect already logged-in admins directly to the dashboard
if(isset($_SESSION['admin_logged_in'])){
    header("Location: manageEvents.php");
    exit();
}

// Store login error message
$error = "";

// Process login form submission
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Process login form submission
    if($username === "admin" && $password === "admin123"){
        // Store admin login session and redirect
        $_SESSION['admin_logged_in'] = true;
        header("Location: manageEvents.php");
        exit();
    } else {
        // Show error if credentials are incorrect
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="Admin-style.css">
</head>
<body class="admin-login-body">

<div class="admin-login-card">

<div class="admin-login-logo">
    <img src="/web/image/sixflags.png" alt="Six Flags Logo"> 
</div>

<h2>Admin Login</h2>

        <!-- Display login error message -->
        <?php if($error): ?>
            <p class="alert-error" style="text-align:center; margin-bottom:12px;">
                <?php echo $error; ?>
            </p>
        <?php endif; ?>
        <!-- Admin Login Form -->
        <form method="POST">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">

            <button type="submit" name="login" class="btn btn-primary" style="width:100%;">Login</button>
        </form>
    </div>

</body>
</html>