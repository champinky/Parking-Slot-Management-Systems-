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

// Parking booking form handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $slot_id = $_POST['slot_id'];
    $name = $_POST['name'];
    $mobile_number = $_POST['mobile_number'];
    $nic_number = $_POST['nic_number'];
    $car_number = $_POST['car_number'];

    // Validate user input to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $name);
    $mobile_number = mysqli_real_escape_string($conn, $mobile_number);
    $nic_number = mysqli_real_escape_string($conn, $nic_number);
    $car_number = mysqli_real_escape_string($conn, $car_number);

    // Get current datetime
    $booking_time = date('Y-m-d H:i:s');

    // Insert booking data into the database
    $sql = "INSERT INTO bookings (user_id, slot_id, name, mobile_number, nic_number, car_number, booking_time) 
            VALUES ('{$_SESSION['user_id']}', '$slot_id', '$name', '$mobile_number', '$nic_number', '$car_number', '$booking_time')";
    if ($conn->query($sql) === TRUE) {
        // Update slot status to booked
        $update_slot_sql = "UPDATE slots SET status='booked' WHERE id='$slot_id'";
        $conn->query($update_slot_sql);

        // Get the inserted booking ID
        $booking_id_query = $conn->query("SELECT LAST_INSERT_ID() as booking_id");
        $booking_id_result = $booking_id_query->fetch_assoc();
        $booking_id = $booking_id_result['booking_id'];

        // Add record to parking history
        $insert_history_sql = "INSERT INTO parking_history (user_id, slot_id, booking_time, payment_status) 
    VALUES ('{$_SESSION['user_id']}', '$slot_id', '$booking_time', 'paid')";
        $conn->query($insert_history_sql);

        // Clear form fields
        $_POST = array();

        // Show confirmation message
        $confirmation_message = "Booking successful! Your Booking ID is $booking_id";

        // Redirect to payment page with the inserted booking ID
        header('Location: payment.php?booking_id=' . $booking_id);
        exit();
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }


}

// Fetch available slots
$sql = "SELECT id, slot_number FROM slots WHERE status='available'";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="parking.css">
    <link rel="stylesheet" href="header.css">
    <title>Parking Booking - Smart Parking</title>
</head>

<body>
    <h1>Parking Booking</h1>

    <?php
    if (isset($confirmation_message)) {
        echo "<p style='color: green;'>$confirmation_message</p>";
    } elseif (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="slot_id">Select Parking Slot:</label>
        <select id="slot_id" name="slot_id" required>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>Slot {$row['slot_number']}</option>";
            }
            ?>
        </select>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="mobile_number">Mobile Number:</label>
        <input type="text" id="mobile_number" name="mobile_number" required>

        <label for="nic_number">NIC Number:</label>
        <input type="text" id="nic_number" name="nic_number" required>

        <label for="car_number">Car Number:</label>
        <input type="text" id="car_number" name="car_number" required>

        <button type="submit">Book Parking</button>
    </form>

    <script src="script.js"></script>
</body>

</html>