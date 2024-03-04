<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexStyles.css">
    <!-- <link rel="stylesheet" href="header.css"> -->
    <title>Smart Parking</title>
</head>

<body>
    <header>
        <h1>Welcome to Smart Parking</h1>
    </header>
    <nav>
        <ul>
            <?php if (isset($_SESSION['user_id'])) {
                ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <?php
            } ?>


            <?php if (!isset($_SESSION['user_id'])) {
                ?>
                                <li><a href="admin.php">Admin Dashboard</a></li>

                <li><a href="parking.php">Book Parking</a></li>
                <li><a href="history.php">Parking History</a></li>
                <li><a href="logout.php">Logout</a></li>
                <?php
            } ?>

        </ul>
    </nav>
    <script src="script.js"></script>
</body>

</html>