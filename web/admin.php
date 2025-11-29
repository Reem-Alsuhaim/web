<?php
session_start();

if(isset($_SESSION['admin_logged_in'])){
    header("Location: manageEvents.php");
    exit();
}

$error = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username === "admin" && $password === "admin123"){
        $_SESSION['admin_logged_in'] = true;
        header("Location: manageEvents.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body class="admin-login-body">

<div class="admin-login-card">

<div class="admin-login-logo">
    <img src="/web/image/sixflags.png" alt="Six Flags Logo"> 
</div>

<h2>Admin Login</h2>


        <?php if($error): ?>
            <p class="alert-error" style="text-align:center; margin-bottom:12px;">
                <?php echo $error; ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit" name="login" class="btn btn-primary" style="width:100%;">Login</button>
        </form>
    </div>

</body>
</html>
