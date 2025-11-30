<?php
session_start();

// Restrict access to admin users only
if(!isset($_SESSION['admin_logged_in'])){ header("Location: admin.php"); exit(); }

// Load database configuration
include("config.php");


// Fetch all bookings with related user and event information
$sql = "
SELECT 
    b.*,           
    b.booking_date,    
    u.name AS uname,  
    u.email,          
    e.name AS ename,    
    e.event_date,    
    e.event_time    
FROM bookings b
JOIN users u ON b.user_id = u.id
JOIN events e ON b.event_id = e.id
ORDER BY b.booking_date DESC;
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
    <link rel="stylesheet" href="Admin-style.css">
</head>

<body>

    <?php include "admin_sidebar.php"; ?>

    <main class="main-content">
        <h2>All Bookings</h2>

        <table class="table">
            <thead>
            <tr>
            <th>User</th>
            <th>Email</th>
            <th>Booking Date</th>
            <th>Event</th>
            <th>Event Date</th>
            <th>Tickets</th>
            <th>Total Price</th>
            </tr>
            </thead>
            <tbody>
                <?php if($result && $result->num_rows > 0): ?>

                    <!-- Display each booking record -->
                    <?php while($row=$result->fetch_assoc()): ?>
                        <tr>
                        <td><?= $row['uname']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['booking_date']; ?></td>
                        <td><?= $row['ename']; ?></td>
                        <td><?= $row['event_date']; ?></td>
                        <td><?= $row['quantity']; ?></td>
                        <td> <img src="/web/image/riyal.svg" class="sar-icon" style="width: 12px; margin-right: 4px;"><?= $row['total_price']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <!-- Message when no bookings exist -->
                    <tr><td colspan="7" style="text-align:center;">No bookings yet.</td></tr>
                <?php endif; ?>

            </tbody>
        </table>
    </main>
</body>
</html>
