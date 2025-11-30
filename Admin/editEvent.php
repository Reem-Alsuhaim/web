<?php
session_start();

// Restrict access to admin users only
if(!isset($_SESSION['admin_logged_in'])){ header("Location: admin.php"); exit(); }

// Load database configuration
include("config.php");

// Get event ID from the URL (default 0 if not provided)
$id = $_GET['id'] ?? 0;

// Fetch current event data to display in the form
$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

// Store validation errors
$error = "";

// Process the update request when the form is submitted
if(isset($_POST['update'])){
    // Read updated input values
    $name = $_POST['name'];
    $ed   = $_POST['event_date'];
    $et   = $_POST['event_time'];
    $loc  = $_POST['location'];
    $price = $_POST['price'];
    $max  = $_POST['available'];
    $des  = $_POST['description'];
    $img  = $_POST['image'];

    // Validate required fields
    if($name === "" || $ed === "" ||$et === "" || $loc === "" || $price === "" || $max === "" || $des === "" || $img === ""){
        $error = "All fields are required.";
    } else {
        // Update event details in the database
        $stmt2 = $conn->prepare("UPDATE events SET name=?, event_date=?, event_time=?, location=?, price=?, available=? , description=? , image=? WHERE id=?");
        $stmt2->bind_param("ssssdissi", $name, $ed, $et, $loc, $price, $max, $des , $img , $id);
        $stmt2->execute();
        // Redirect back to management page after updating
        header("Location: manageEvents.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link rel="stylesheet" href="Admin-style.css">
    </head>
<body>
    <?php include "admin_sidebar.php"; ?>

    <main class="main-content">
        <h2>Edit Event</h2>

        <!-- Display validation error message -->
        <?php if($error): ?>
            <p style="color:red;"><?= $error; ?></p>
        <?php endif; ?>

        <!-- Event edit form -->
        <form method="POST">

            <label>Name</label>
            <input type="text" name="name" value="<?= $event['name']; ?>" required>

            <label>Date</label>
            <input type="date" name="event_date"
                value="<?= date('Y-m-d', strtotime($event['event_date'])); ?>" required>

            <label>Time</label>
            <input type="time" name="event_time"
                value="<?= date('H:i', strtotime($event['event_time'])); ?>" required>

            <label>Location</label>
            <input type="text" name="location" value="<?= $event['location']; ?>" required>

            <label>Price</label>
            <input type="number" name="price" value="<?= $event['price']; ?>" required>

            <label>Max Tickets</label>
            <input type="number" name="available" value="<?= $event['available']; ?>" required>

            <label>Description</label>
            <input type="text" name="description" value="<?= $event['description']; ?>" required>

            <label>Image</label>
            <input type="text" name="image" value="<?= $event['image']; ?>" required>

            <button type="submit" name="update" class="btn btn-primary">Update Event</button>
            
            <!-- Back button -->
            <a href="manageEvents.php" class="admin-back-btn">Back</a>
        </form>

    </main>
</body>
</html>

