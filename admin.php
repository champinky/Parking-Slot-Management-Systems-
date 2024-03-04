<?php
session_start();

// Check if admin is not logged in, redirect to index.php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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

// Fetch parking slots and bookings for the admin dashboard
$sql = "SELECT slots.id AS slot_id, slot_number, status, user_id, name, mobile_number, car_number, booking_time, payment_status
        FROM slots
        LEFT JOIN bookings ON slots.id = bookings.slot_id
        ORDER BY slot_number";

$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Dashboard - Smart Parking</title>
</head>
<body>
    <h1>Admin Dashboard - Smart Parking</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Slot Number</th><th>Status</th><th>User ID</th><th>Name</th><th>Mobile Number</th><th>Car Number</th><th>Booking Time</th><th>Payment Status</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['slot_number'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['mobile_number'] . "</td>";
            echo "<td>" . $row['car_number'] . "</td>";
            echo "<td>" . $row['booking_time'] . "</td>";
            echo "<td>" . $row['payment_status'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No bookings available.</p>";
    }
    ?>

    <p><a href="logout.php">Logout</a></p>

    <script src="script.js"></script>
</body>
</html>
