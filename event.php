<?php
session_start();
include 'config.php';

$userName = $_SESSION["name"] ?? "Guest";

// get event id
if (!isset($_GET['id'])) {
    die("No event ID specified.");
}
$event_id = (int)$_GET['id'];

// جلب بيانات الحدث من جدول events
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
if (!$event) die("Event not found.");

// حساب عدد التذاكر المتاحة بعد خصم الحجوزات
$stmtBooked = $conn->prepare("SELECT SUM(quantity) as booked FROM bookings WHERE event_id = ?");
$stmtBooked->bind_param("i", $event_id);
$stmtBooked->execute();
$resultBooked = $stmtBooked->get_result()->fetch_assoc();
$booked = $resultBooked['booked'] ?? 0;

// المتاح حالياً
$availableTickets = $event['available'] - $booked;
if ($availableTickets < 0) $availableTickets = 0;

$error_msg = "";
$success_msg = "";

// Add to cart logic
if (isset($_POST['add_to_cart'])) {

    $qty = (int)$_POST['qty'];

    // 1) check user is login
    if (!isset($_SESSION['user_id'])) {
        $error_msg = "⚠️ You must be logged in to add tickets to your cart.";
    }

    // 2) make sure 1 event is added to cart
    if (!$error_msg && !empty($_SESSION['cart'])) {
        $existingEventId = array_key_first($_SESSION['cart']);
        if ($existingEventId != $event_id) {
            $error_msg = "You can only book tickets for one event at a time. Please empty your cart first.";
        }
    }

    // 3) available tickets
    if (!$error_msg) {
        $existingQty = $_SESSION['cart'][$event_id] ?? 0;

        if ($qty + $existingQty > $availableTickets) {
            $remaining = $availableTickets - $existingQty;
            $error_msg = "Not enough tickets available! You can only add $remaining more tickets.";
        }
    }

    // 4) add to cart
    if (!$error_msg) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        $_SESSION['cart'][$event_id] = $existingQty + $qty;
        $success_msg = "$qty tickets added to cart!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($event['name']); ?> - Event Booking</title>
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

</head>
<body>

<header>
    <div class="header-logo">
        <img src="sixflags.png" class="logo" alt="Logo">
        <span>Six Flags</span>
    </div>

    <div class="welcome-text">
        <span>Welcome <?php echo htmlspecialchars($userName); ?>.</span>
    </div>

    <div class="user-actions">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="cart.php">
                <i class="fa-solid fa-cart-shopping"></i>
                Cart
            </a>
            <a href="logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>
        <?php else: ?>
            <a href="index.php">
                <i class="fa-solid fa-right-to-bracket"></i>
                Login
            </a>
        <?php endif; ?>
    </div>
</header>

<main>
    <section class="event-details-section">

        <div class="event-container">

             <!-- زر الرجوع للهوم -->
            <a href="home.php" class="back-btn">
                <i class="fa-solid fa-caret-left"></i>
            </a>

            <!-- صورة الحدث -->
            <div class="event-image">
                <img src="image/<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['image']); ?>">
            </div>

            <!-- تفاصيل الحدث -->
            <div class="event-details">
                <h1><?php echo htmlspecialchars($event['name']); ?></h1>

                <p><strong>Date:</strong> <?= htmlspecialchars($event['event_date']); ?></p>
                <p><strong>Time:</strong> <?= htmlspecialchars($event['event_time']); ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>
                <p style="white-space: pre-wrap;"><strong>Description:</strong> <?= htmlspecialchars($event['description']); ?></p>
                <p><strong>Price:</strong> <?= $event['price']; ?></p>
                <p><strong>Available:</strong> <?= $availableTickets; ?></p>

                <form method="POST">
                    <label>Number of tickets:</label>
                    <input type="number" name="qty"
                        min="1"
                        max="<?php echo $availableTickets; ?>"
                        required>
                    <button type="submit" name="add_to_cart" class="Btn-type2">Add to Cart</button>
                </form>

                <?php if ($error_msg) echo "<p class='error'>$error_msg</p>"; ?>
                <?php if ($success_msg) echo "<p class='success'>$success_msg</p>"; ?>
            </div>

        </div>
    </section>
</main>

<footer>
    <p>©  Six Flags Qiddiya. All Rights Reserved. — <?php echo date("Y"); ?></p>
</footer>

</body>
</html>
