<?php
session_start();

if (!isset($_SESSION['name'])) {
    header('location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "coffeeops_manage";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$client_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM coffee_data WHERE id = $client_id";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css">
    <!-- Add your head content here -->
</head>
<body>

    <<nav>
        <a href="#">Home</a>
        <a href="#">Products</a>
        <a href="#">Orders</a>
        <a href="#">Reports</a>
        <!-- Your navigation links here -->
    </nav>

    <div class="container mt-5">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php $row = $result->fetch_assoc(); ?>
            <h2>Client Details</h2>
            <p>ID: <?php echo $row['id']; ?></p>
            <p>Name: <?php echo $row['customer_name']; ?></p>
            <p>Phone Number: <?php echo $row['phone_number']; ?></p>
            <p>Email: <?php echo $row['email']; ?></p>
            <p>Address: <?php echo $row['address']; ?></p>
            <!-- Add other details as needed -->
        <?php else: ?>
            <p>No client details found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
