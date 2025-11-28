<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){ header("Location: admin.php"); exit(); }
include("config.php");


$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

$stmt2 = $conn->prepare("SELECT COUNT(*) AS c FROM bookings WHERE event_id=?");
$stmt2->bind_param("i", $id);
$stmt2->execute();
$hasBookings = $stmt2->get_result()->fetch_assoc()['c'] > 0;

$msg = "";

if(isset($_POST['confirm'])){
    if($hasBookings){
        $msg = "Cannot delete event with existing bookings.";
    } else {
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
    <link rel="stylesheet" href="style2.css">
    </head>
<body>

<?php include "admin_sidebar.php"; ?>

<main class="main-content">
<h2>Delete Event</h2>

<?php if($msg): ?><p style="color:red;"><?= $msg; ?></p><?php endif; ?>

<?php if($event): ?>

        <p><b>Name:</b> <?= $event['name']; ?></p>
        <p><b>Date:</b> <?= $event['event_date']; ?></p>
        <p><b>Time:</b> <?= $event['event_time']; ?></p>
        <p><b>Location:</b> <?= $event['location']; ?></p>
        <p><b>Price:</b> <?= $event['price']; ?></p>
        <p><b>Max Tickets:</b> <?= $event['available']; ?></p>
        <p><b>Description:</b> <?= $event['description']; ?></p>
        <p><b>Image:</b> <?= $event['image']; ?></p>

<?php if($hasBookings): ?>
    <p style="color:red;">⚠ This event cannot be deleted because it has bookings.</p>
<?php else: ?>
<form method="POST">
    <button name="confirm" class="btn btn-danger">Yes, Delete</button>
</form>
<?php endif; ?>

<?php else: ?>
<p>Event not found.</p>
<?php endif; ?>
</br>
<a href="manageEvents.php" class="btn btn-outline">Back</a>

</main>
</body>
</html>
