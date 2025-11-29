<?php
session_start();
include 'config.php';


$userName = $_SESSION["name"] ?? "Guest";
// جلب اسم المستخدم


// جلب كل الأحداث من قاعدة البيانات
$events = [];
$query = "SELECT * FROM events";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Event Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <section class="events-grid">
        <?php foreach($events as $event) { ?>
            <div class="event-card" style="background-image: url('<?php echo htmlspecialchars($event['image']); ?>');">

                <div class="event-info">
                    <h3><?php echo htmlspecialchars($event['name']); ?></h3>
                    <p><?php echo htmlspecialchars($event['event_date']); ?></p>

                    <form method="GET" action="event.php">
                        <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                        <button type="submit">Book Now</button>
                    </form>
                </div>

            </div>
        <?php } ?>
    </section>
</main>

<footer>
    <p>©  Six Flags Qiddiya. All Rights Reserved. — <?php echo date("Y"); ?></p>
</footer>

</body>
</html>
