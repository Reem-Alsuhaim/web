<?php
session_start();// Start the session to access session data
session_destroy();
// Redirect user back to the login page
header("Location: index.php");
exit();
?>
