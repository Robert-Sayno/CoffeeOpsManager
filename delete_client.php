<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['name'])) {
    header('location: auth/login.php');
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

// Check if the client ID is provided in the URL
if (isset($_GET['id'])) {
    $clientId = mysqli_real_escape_string($conn, $_GET['id']);

    // Display a confirmation alert
    echo "<script>
            if (confirm('Are you sure you want to delete this client?')) {
                // If confirmed, proceed with deletion
                window.location.href = 'delete_client_confirm.php?id=$clientId';
            } else {
                // If not confirmed, redirect back to the clients page
                window.location.href = 'clients.php';
            }
          </script>";
} else {
    echo "Client ID not provided";
}

$conn->close();
?>
