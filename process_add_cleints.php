<?php
session_start();

if (!isset($_SESSION['name'])) {
    header('location: auth/login.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connect to the database (replace these with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "coffeeops_manage";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $customerName = $_POST['customerName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Handle file upload
    $customerPhoto = $_FILES['customerPhoto']['name'];
    $uploadDir = "uploads/"; // Change this directory to your desired upload location
    $targetFilePath = $uploadDir . basename($customerPhoto);

    move_uploaded_file($_FILES['customerPhoto']['tmp_name'], $targetFilePath);

    // Insert data into the database
    $insertSql = "INSERT INTO coffee_data (name, phone_number, email, address, customer_photo) 
                  VALUES ('$customerName', '$phoneNumber', '$email', '$address', '$customerPhoto')";

    if ($conn->query($insertSql) === TRUE) {
        echo "Data saved successfully";
    } else {
        echo "Error saving data: " . $conn->error;
    }

    $conn->close();
} else {
    // Redirect if the form is not submitted
    header('location: index.php');
    exit();
}
?>
