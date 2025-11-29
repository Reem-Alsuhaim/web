<?php
session_start();

// Restrict access to admin users only
if(!isset($_SESSION['admin_logged_in'])){ header("Location: admin.php"); exit(); }

// Load database configuration
include("config.php");


// Get event ID from the URL
$id = $_GET['id'] ?? 0;

// Fetch event information from the database
$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Event</title>
    <link rel="stylesheet" href="style2.css">
    </head>
<body>

<?php include "admin_sidebar.php"; ?>

<main class="main-content">
    <h2>View Event</h2>

    <!-- Display event details if found -->
    <?php if($event): ?>
        <p><b>Name:</b> <?= $event['name']; ?></p>
        <p><b>Date:</b> <?= $event['event_date']; ?></p>
        <p><b>Time:</b> <?= $event['event_time']; ?></p>
        <p><b>Location:</b> <?= $event['location']; ?></p>
        <p><b>Price:</b> <?= $event['price']; ?></p>
        <p><b>Max Tickets:</b> <?= $event['available']; ?></p>
        <p><b>Description:</b> <?= $event['description']; ?></p>
        <p><b>Image:</b> <?= $event['image']; ?></p>

        </br>
        <!-- Back button -->
        <a href="manageEvents.php" class="admin-back-btn">Back</a>

    <?php else: ?>
        <!-- Message when event ID is invalid -->
        <p>Event not found.</p>
    <?php endif; ?>
</main>

</div>
</body>
</html>
