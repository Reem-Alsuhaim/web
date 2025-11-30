<?php
session_start();
// Log out the admin and redirect to the login page
session_destroy();
header("Location: admin.php");
exit();
