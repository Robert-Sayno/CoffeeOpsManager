<?php
session_start();

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

// Your HTML code here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $coffeeBrought = $_POST['coffeeBrought'];
    $output = $_POST['output'];
    $unitPrice = $_POST['unitPrice'];
    $date = date("Y-m-d");

    // Calculate residue and total amount
    $residue = $output - $coffeeBrought;
    $totalAmountPaid = $unitPrice * $coffeeBrought;

    // Assuming you have a unique identifier for each entry in the client_details table
    $insertSql = "INSERT INTO client_details (client_id, date, coffee_brought, output, residue, unit_price, total_amount_paid) 
                  VALUES ($client_id, '$date', $coffeeBrought, $output, $residue, $unitPrice, $totalAmountPaid)";

    if ($conn->query($insertSql) === TRUE) {
        echo '<script>alert("Details added successfully");</script>';
        header('Location: manage_client.php?id=' . $client_id); // Redirect to clients.php with the client's ID
        exit();
    } else {
        echo '<script>alert("Error adding details: ' . $conn->error . '");</script>';
    }
}

$conn->close();
?>
