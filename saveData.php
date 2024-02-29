<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['name'])) {
    echo "Error: Unauthorized access. Please log in.";
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

// Get and sanitize data from the POST request
$customerName = mysqli_real_escape_string($conn, $_POST['customerName']);
$phoneNumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
$email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : null;
$address = mysqli_real_escape_string($conn, $_POST['address']);

// Validate phone number format
if (!preg_match('/^[0-9]{10,15}$/', $phoneNumber)) {
    echo "Error: Invalid phone number format";
    exit();
}

// Validate email format
if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Error: Invalid email format";
    exit();
}
// Process the uploaded customer photo
$customerPhoto = null;
if (isset($_FILES['customerPhoto']) && $_FILES['customerPhoto']['error'] == UPLOAD_ERR_OK) {
    $customerPhoto = file_get_contents($_FILES['customerPhoto']['tmp_name']);
    $customerPhoto = mysqli_real_escape_string($conn, $customerPhoto);
}

// Insert data into the database
$sql = "INSERT INTO coffee_data (customer_name, phone_number, email, address, customer_photo) VALUES ('$customerName', '$phoneNumber', '$email', '$address', '$customerPhoto')";
if ($conn->query($sql) === TRUE) {
    // Data saved successfully
    echo "<script>
            alert('Client added successfully');
            window.location.href = 'clients.php';
          </script>";
    exit(); // Make sure to exit after header redirect

} else {
    // Error in saving data
    echo "Error: " . $sql . "<br>" . $conn->error;
    echo '<script>alert("Error saving data. Please try again.");</script>';
}



$conn->close();
?>
