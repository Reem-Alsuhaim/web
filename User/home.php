<?php
session_start();
include 'config.php';

// Get logged-in user's name (or Guest if not logged in)
$userName = $_SESSION["name"] ?? "Guest";



// Fetch all events from the database
$events = [];
$query = "SELECT * FROM events";
$result = mysqli_query($conn, $query);
// Store results inside the $events array
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Page Title -->
    <title>Home - Event Booking System</title>
        <!-- Responsive Design -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="User-style.css">
     <!-- Icons -->
    <link rel="stylesheet" 
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

</head>
<body>
<!-- ======================================
     HEADER (Logo + Welcome + Navigation)
====================================== -->
<header>
    <div class="header-logo">
        <img src="/web/image/Six-Flags-login.png" class="logo" alt="Logo">
        <span>Six Flags</span>
    </div>
<!-- Show user name if logged in -->
    <div class="welcome-text">
        <span>Welcome <?php echo htmlspecialchars($userName); ?>.</span>
    </div>

    <div class="user-actions">
           <!-- If user is logged in: show cart + logout -->
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
<!-- ======================================
     MAIN CONTENT: EVENTS GRID
====================================== -->
<main>
    <section class="events-grid">
        <!-- Loop through all events and display them -->
        <?php foreach($events as $event) { ?>
            <div class="event-card" style="background-image: url('/web/image/<?php echo htmlspecialchars($event['image']); ?>');"> <!-- Event card with background image -->

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
<!-- ======================================
     FOOTER
====================================== -->
<footer>
    <p>©  Six Flags Qiddiya. All Rights Reserved. — <?php echo date("Y"); ?></p>
</footer>

</body>
</html>
