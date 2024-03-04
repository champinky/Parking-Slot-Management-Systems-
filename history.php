<?php
session_start();

// Check if user is not logged in, redirect to index.php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parking_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user's parking history
$user_id = $_SESSION['user_id'];
$history_sql = "SELECT parking_history.id AS history_id, slot_number, booking_time, payment_status
                FROM parking_history
                INNER JOIN slots ON parking_history.slot_id = slots.id
                WHERE user_id='$user_id'
                ORDER BY booking_time DESC";

$history_result = $conn->query($history_sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Parking History - Smart Parking</title>
</head>
<body>
    <h1>Parking History</h1>

    <?php
    if ($history_result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Slot Number</th><th>Booking Time</th><th>Payment Status</th></tr>";

        while ($row = $history_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['slot_number'] . "</td>";
            echo "<td>" . $row['booking_time'] . "</td>";
            echo "<td>" . $row['payment_status'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No parking history available.</p>";
    }
    ?>

    <p><a href="index.php">Back to Home</a></p>

    <script src="script.js"></script>
</body>
</html>
