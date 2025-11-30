<?php
// addEvent.php
session_start();

// Start session and verify admin authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect unauthorized users to the admin login page
    header("Location: admin.php");
    exit();
}

// Load database configuration file
include("config.php");

// Variables to store error or success messages
$error = "";
$success = "";

// Process the form when the 'Add Event' button is clicked
if (isset($_POST['add'])) {

    // Retrieve and sanitize form inputs
    $name        = trim($_POST['name']);
    $dt = $_POST['date_time']; // Input format: "YYYY-MM-DDTHH:MM"
    $event_date = date('Y-m-d', strtotime($dt)); // YYYY-MM-DD
    $event_time = date('H:i:s', strtotime($dt)); // HH:MM:SS

    $location    = trim($_POST['location']);
    $price       = $_POST['price'];
    $max_tickets = $_POST['available'];
    $description = $_POST['description'];
    $image       = trim($_POST['image']); // Expecting only the image file name

     // Basic validation to ensure required fields are not empty
    if ($name === "" || $event_date === "" || $event_time === "" || $location === "" || $price === "" || $max_tickets === "" || $image === "" || $description === "") {
        $error = "All fields are required.";
    } else {

        // Prepare SQL statement to insert a new event into the database
        $stmt = $conn->prepare("INSERT INTO events (name, event_date, event_time, location, price, available, image , description)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdiss", $name, $event_date, $event_time, $location, $price, $max_tickets, $image, $description);
        
        if ($stmt->execute()) {
            // After adding the event, redirect to the event management page
            header("Location: manageEvents.php");
            exit();
        } else {
            $error = "Error while adding event.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Event</title>
    <link rel="stylesheet" href="Admin-style.css">
</head>

<body>

    <?php include "admin_sidebar.php"; ?>

    <main class="main-content">
        <h2>Add New Event</h2>

        <?php if ($error): ?>
            <p style="color:red;"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Event Name</label>
            <input type="text" name="name" required>

            <label>Date &amp; Time</label>
            <input type="datetime-local" name="date_time" required>

            <label>Location</label>
            <input type="text" name="location" required>

            <label>Price</label>
            <input type="number" step="0.01" name="price" required>

            <label>Maximum Tickets</label>
            <input type="number" name="available" required>

            <label>Description</label>
            <input type="text" name="description" required>

            <label>Image (file name only)</label>
            <input type="text" name="image" placeholder="example.jpg" required>

            <button type="submit" name="add" class="btn btn-primary">Add Event</button>
            <a href="manageEvents.php" class="admin-back-btn">Back</a>

        </form>

    </main>
</body>
</html>

