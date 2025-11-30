<?php
session_start();
require 'config.php';

// user must be logged in to access cart
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?login_required=1");
    exit();
}

// get user name
$userName = $_SESSION['name'];

// get cart items
$cart = $_SESSION['cart'] ?? [];
$totalPrice = 0;
$cartItems = [];
$success_msg = "";

// reserve tickets
if (isset($_POST['reserve']) && $cart) {
    foreach ($cart as $event_id => $qty) {

        //Fetch event price from database
        $stmtPrice = $conn->prepare("SELECT price FROM events WHERE id=?");
        $stmtPrice->bind_param("i", $event_id);
        $stmtPrice->execute();
        $priceResult = $stmtPrice->get_result()->fetch_assoc();
        $price = $priceResult['price'];
        $total = $qty * $price;

        //Insert booking record into the bookings table
        $stmtBooking = $conn->prepare("INSERT INTO bookings (user_id, event_id, quantity, total_price, booking_date) VALUES (?, ?, ?, ?, NOW())");
        $stmtBooking->bind_param("iiid", $_SESSION['user_id'], $event_id, $qty, $total);
        $stmtBooking->execute();
    }
//Clear cart after successful booking
    $_SESSION['cart'] = [];
    $cart = [];
    $success_msg = "Booking confirmed! Tickets reserved.";
}
// Empty cart manually
if (isset($_POST['empty_cart'])) {
    $_SESSION['cart'] = [];
    $cart = [];
}

//Fetch all bookings for the logged-in user
$bookings = [];
$stmtAll = $conn->prepare("
    SELECT b.id, b.user_id, b.event_id, b.quantity, b.total_price, b.booking_date, e.name as event_name
    FROM bookings b
    JOIN events e ON b.event_id = e.id
    WHERE b.user_id = ?
    ORDER BY b.booking_date DESC
");
$stmtAll->bind_param("i", $_SESSION['user_id']);
$stmtAll->execute();
$resultAll = $stmtAll->get_result();
while ($row = $resultAll->fetch_assoc()) {
    $bookings[] = $row;
}


// get event information
if ($cart) {
    $ids = implode(',', array_keys($cart));
    $query = "SELECT * FROM events WHERE id IN ($ids)";
    $result = $conn->query($query);

    while ($event = $result->fetch_assoc()) {
        $qty = $cart[$event['id']];
        $price = $event['price'];
        $total = $qty * $price;
        $totalPrice += $total;

        $cartItems[] = [
            'name' => $event['name'],
            'date' => $event['event_date'],
            'qty' => $qty,
            'price' => $price,
            'total' => $total
        ];
    }
}

// Get Date & Time
$currentDateTime = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart - Event Booking</title>
   <link rel="stylesheet" href="User-style.css"> <!--Main Stylesheet-->
<link rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!--Icons-->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Tajawal:wght@300;400;500;700&display=swap" 
      rel="stylesheet">  <!--Fonts-->

</head>
<body>
<!--HEADER SECTION (Top Navigation Bar) -->
<header>
    <div class="header-logo">
        <img src="/web/image/Six-Flags-login.png" class="logo" alt="Logo"> <!-- Site Logo -->
        <span>Six Flags</span>
    </div>
  <!-- Greeting the logged-in user -->
    <div class="welcome-text">
        <span>Welcome <?php echo htmlspecialchars($userName); ?> .</span>
    </div>
 <!-- Navigation Buttons -->
    <div class="user-actions">
        <a href="cart.php">
            <i class="fa-solid fa-cart-shopping"></i>
            Cart
        </a>
        <a href="logout.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </div>
</header>

<main>
    <section class="cart-section">

         <a href="home.php" class="back-btn">
                <i class="fa-solid fa-caret-left"></i>
        </a>


        <h1>Your Cart</h1>
        <p><strong>Current Date & Time:</strong> <?php echo $currentDateTime; ?></p>  <!-- Show current date & time -->

        <?php if ($cartItems) { ?>
            <table class="cart-table"> <!-- Cart Table -->
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cartItems as $item) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['date']); ?></td>
                            <td><?php echo $item['qty']; ?></td>
                            <td>
                            <img src="/web/image/riyal.svg" class="sar-icon" style="width: 12px; margin-right: 4px;">
                            <?php echo number_format($item['price'], 2); ?>
                            </td>                                    
                            <td>
                             <img src="/web/image/riyal.svg" class="sar-icon" style="width: 12px; margin-right: 4px;">
                            <?php echo number_format($item['total'],2); ?> 
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
<!-- Show total price of the cart -->
            <p><strong>Total Price:</strong>  <img src="/web/image/riyal.svg" class="sar-icon" style="width: 12px; margin-right: 4px;"> <?php echo number_format($totalPrice, 2); ?> </p>
<!-- Reserve Tickets Button -->
            <form method="POST">
                <button type="submit" name="reserve">Reserve Tickets</button>
            </form>
  <!-- Empty Cart Button -->
            <form method="POST" >
                <button type="submit" name="empty_cart" class="btn-empty">Empty Cart</button>
            </form>
 <!-- Success message after booking -->
            <?php if ($success_msg) { ?>
                <p class="success"><?php echo htmlspecialchars($success_msg); ?></p>
            <?php } ?>

        <?php } else { ?>
            <p>Your cart is empty.</p> <!-- Message if cart is empty -->
        <?php } ?>
    </section>
   <!--  USER BOOKINGS SECTION -->
    <section>
    <?php if ($bookings): ?>
    <h2>Your Bookings</h2>
        <!-- Table showing all confirmed bookings -->
    <table class="cart-table">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Event</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Booking Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $b): ?>
                <tr>
                    <td><?= $b['id']; ?></td>
                    <td><?= htmlspecialchars($b['event_name']); ?></td>
                    <td><?= $b['quantity']; ?></td>
                    <td> <img src="/web/image/riyal.svg" class="sar-icon" style="width: 12px; margin-right: 4px;"> <?= number_format($b['total_price'],2); ?></td>
                    <td><?= $b['booking_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</section>

</main>
<!--  FOOTER SECTION -->
<footer>
    <p>©  Six Flags Qiddiya. All Rights Reserved. — <?php echo date("Y"); ?></p>
</footer>

</body>
</html>
