<?php
// Database connection parameters
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'coffeeops_manage';

// Check if there is a POST request (Note: This condition might need further clarification)
if (isset($_POST)) {
    // Create a new mysqli connection using the provided parameters
    $conn = new mysqli($server, $username, $password, $database);

    // Check if the connection was successful
    if ($conn) {
        // If successful, you might want to uncomment the line below to display a success message.
        // echo 'Server Connected Success';
    } else {
        // If the connection fails, terminate the script and display the MySQL error.
        die(mysqli_error($conn));
    }
}
?>
