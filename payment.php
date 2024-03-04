<?php
session_start();

// Check if user is not logged in, redirect to index.php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Check if booking_id is set in the URL
if (!isset($_GET['booking_id'])) {
    header('Location: index.php');
    exit();
}

$booking_id = $_GET['booking_id'];

// Fetch booking details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parking_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM bookings WHERE id = '$booking_id' AND user_id = '{$_SESSION['user_id']}'";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    // Invalid booking ID or unauthorized access
    header('Location: index.php');
    exit();
}

$booking = $result->fetch_assoc();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="payment.css">
    <link rel="stylesheet" href="header.css">
    <title>Payment - Smart Parking</title>
</head>

<body>
    <?php include 'header.php'; ?>

    <h1>Payment</h1>

    <p>Booking Details:</p>
    <p>Name: <?php echo $booking['name']; ?></p>
    <p>Mobile Number: <?php echo $booking['mobile_number']; ?></p>
    <p>NIC Number: <?php echo $booking['nic_number']; ?></p>
    <p>Car Number: <?php echo $booking['car_number']; ?></p>
    <p>Booking Time: <?php echo $booking['booking_time']; ?></p>

    <form method="post" action="process_payment.php">
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required>

        <label for="expiry_date">Expiry Date:</label>
        <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YYYY" required>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required>

        <button type="submit">Make Payment</button>
    </form>

    <script src="script.js"></script>
</body>

</html>
