<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){ header("Location: admin.php"); exit(); }
include("config.php");


$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();

$error = "";

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $ed   = $_POST['event_date'];
    $et   = $_POST['event_time'];
    $loc  = $_POST['location'];
    $price = $_POST['price'];
    $max  = $_POST['available'];
    $des  = $_POST['description'];
    $img  = $_POST['image'];

    if($name === "" || $ed === "" ||$et === "" || $loc === "" || $price === "" || $max === "" || $des === "" || $img === ""){
        $error = "All fields are required.";
    } else {
        $stmt2 = $conn->prepare("UPDATE events SET name=?, event_date=?, event_time=?, location=?, price=?, available=? , description=? , image=? WHERE id=?");
        $stmt2->bind_param("ssssdissi", $name, $ed, $et, $loc, $price, $max, $des , $img , $id);
        $stmt2->execute();

        header("Location: manageEvents.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link rel="stylesheet" href="style2.css">
    </head>
<body>
<?php include "admin_sidebar.php"; ?>

<main class="main-content">
<h2>Edit Event</h2>

<?php if($error): ?>
    <p style="color:red;"><?= $error; ?></p>
<?php endif; ?>

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
    <a href="manageEvents.php" class="btn btn-outline">Back</a>
</form>

</main>
</body>
</html>
