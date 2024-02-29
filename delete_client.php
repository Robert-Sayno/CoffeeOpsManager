<?php
// delete_client_confirm.php

$servername = "localhost";
$username = "root";
$password = "";
$database = "coffeeops_manage";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the client ID from the URL or request body
$client_id = isset($_GET['id']) ? $_GET['id'] : file_get_contents('php://input');
$client_id = mysqli_real_escape_string($conn, $client_id);

// Delete related records in client_details
$deleteDetailsSql = "DELETE FROM client_details WHERE client_id = '$client_id'";

if ($conn->query($deleteDetailsSql) === TRUE) {
    // Delete the client in coffee_data
    $deleteSql = "DELETE FROM coffee_data WHERE id = '$client_id'";

    if ($conn->query($deleteSql) === TRUE) {
        // JavaScript alert and redirect on successful deletion
        echo "<script>
                alert('Client deleted successfully');
                window.location.href = 'clients.php';
              </script>";
    } else {
        // JavaScript alert and redirect on deletion failure
        echo "<script>
                alert('Error deleting client: " . $conn->error . "');
                window.location.href = 'clients.php';
              </script>";
    }
} else {
    // JavaScript alert and redirect on deletion of client_details failure
    echo "<script>
            alert('Error deleting client details: " . $conn->error . "');
            window.location.href = 'clients.php';
          </script>";
}

$conn->close();
?>
