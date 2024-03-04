<nav>
    <ul>
        <?php if (isset($_SESSION['user_id'])) { ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php } ?>

        <li><a href="parking.php">Book Parking</a></li>
        <li><a href="admin.php">Admin Dashboard</a></li>

        <?php if (!isset($_SESSION['user_id'])) { ?>
            <li><a href="logout.php">Logout</a></li>
        <?php } ?>
    </ul>
</nav>
