<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){ header("Location: admin.php"); exit(); }
include("config.php");


$id = $_GET['id'] ?? 0;

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

    <?php if($event): ?>
        <p><b>Name:</b> <?= $event['name']; ?></p>
        <p><b>Date:</b> <?= $event['event_date']; ?></p>
        <p><b>Time:</b> <?= $event['event_time']; ?></p>
        <p><b>Location:</b> <?= $event['location']; ?></p>
        <p><b>Price:</b> <?= $event['price']; ?></p>
        <p><b>Max Tickets:</b> <?= $event['available']; ?></p>
        <p style= "white-space: pre-wrap;" ><b>Description:</b> <?= $event['description']; ?></p>
        <p style="text-align: center;">
            <img width="50%" 
                style="border: 3px solid #000; border-radius: 15px;"
                src="/web/image/<?php echo htmlspecialchars($event['image']); ?>"
                alt="<?php echo htmlspecialchars($event['image']); ?>">
        </p>
        </br>
        <a href="manageEvents.php" class="admin-back-btn">Back</a>

    <?php else: ?>
        <p>Event not found.</p>
    <?php endif; ?>
</main>

</div>
</body>
</html>
