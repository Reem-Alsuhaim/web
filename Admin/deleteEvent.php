<?php
session_start();

// Start session and restrict access to admin users only
if(!isset($_SESSION['admin_logged_in'])){ header("Location: admin.php"); exit(); }

// Load database configuration
include("config.php");

// Retrieve the event ID from the URL (default to 0 if not provided)
$id = $_GET['id'] ?? 0;

// Fetch event details using a prepared statement
$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

// Check if the event has any existing bookings
$stmt2 = $conn->prepare("SELECT COUNT(*) AS c FROM bookings WHERE event_id=?");
$stmt2->bind_param("i", $id);
$stmt2->execute();
$hasBookings = $stmt2->get_result()->fetch_assoc()['c'] > 0;

// Message to display errors or restrictions during deletion
$msg = "";

// Process deletion when the admin confirms
if(isset($_POST['confirm'])){

    // If bookings exist, prevent deletion and show a warning
    if($hasBookings){
        $msg = "Cannot delete event with existing bookings.";
    } else {
        // Delete the event from the database and redirect back to the management page
        $stmt3 = $conn->prepare("DELETE FROM events WHERE id=?");
        $stmt3->bind_param("i", $id);
        $stmt3->execute();
        header("Location: manageEvents.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Event</title>
    <link rel="stylesheet" href="Admin-style.css">
    </head>
<body>

    <?php include "admin_sidebar.php"; ?>

    <main class="main-content">
        <h2>Delete Event</h2>

        <?php if($msg): ?><p style="color:red;"><?= $msg; ?></p><?php endif; ?>
        <div class="view-event-box">
            <?php if($event): ?>
                <!-- Display event details for confirmation -->
                <p><b>Name:</b> <?= $event['name']; ?></p>
                <p><b>Date:</b> <?= $event['event_date']; ?></p>
                <p><b>Time:</b> <?= $event['event_time']; ?></p>
                <p><b>Location:</b> <?= $event['location']; ?></p>
                <p><b>Price:</b> <img src="/web/image/riyal.svg" class="sar-icon" style="width: 12px; margin-right: 4px;"><?= $event['price']; ?></p>
                <p><b>Max Tickets:</b> <?= $event['available']; ?></p>
                <?= $event['description']; ?></p>

                <p style="white-space: pre-wrap;"><?= $event['description']; ?></p>

                <img class="event-image"
                    src="/web/image/<?= htmlspecialchars($event['image']); ?>"
                    alt="<?= htmlspecialchars($event['image']); ?>">

                <?php if($hasBookings): ?>
                    <!-- Display a warning if the event cannot be deleted due to existing bookings -->
                    <p style="color:red;">⚠ This event cannot be deleted because it has bookings.</p>
                <?php else: ?>
                    <!-- Confirmation button to delete the event -->
                    <form method="POST">
                        <button name="confirm" class="btn btn-danger">Yes, Delete</button>
                    </form>
                <?php endif; ?>

            <?php else: ?>
                <!-- Show message if event is not found -->
                <p>Event not found.</p>
            <?php endif; ?>
            </br>
            <!-- Back button to return to the event management page -->
            <a href="manageEvents.php" class="admin-back-btn">Back</a>
        </div>
    </main>
</body>
</html>
