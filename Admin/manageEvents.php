<?php
session_start();

// Restrict access to admin users only
if(!isset($_SESSION['admin_logged_in'])){ header("Location: admin.php"); exit(); }

// Load database configuration
include("config.php");

// Fetch all events ordered by date
$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Events</title>
    <link rel="stylesheet" href="Admin-style.css">
    </head>
<body>

<?php include "admin_sidebar.php"; ?>

<main class="main-content">
    <h2>Manage Events</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Event</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <!-- Display all events in the table -->
        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['event_date']); ?></td>

                    <td>
                        <!-- Action links for each event -->
                        <a href="viewEvent.php?id=<?= $row['id'] ?>">View</a> |
                        <a href="editEvent.php?id=<?= $row['id'] ?>">Edit</a> |
                        <a href="deleteEvent.php?id=<?= $row['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <!-- Message when no events exist -->
            <tr><td colspan="6">No events found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</main>

</div>
</body>
</html>

