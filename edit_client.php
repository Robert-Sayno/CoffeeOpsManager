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

    // Fetch client data from the database
    $sql = "SELECT * FROM coffee_data WHERE id = $clientId";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get and sanitize updated data from the form
            $updatedName = mysqli_real_escape_string($conn, $_POST['updatedName']);
            $updatedPhoneNumber = mysqli_real_escape_string($conn, $_POST['updatedPhoneNumber']);
            $updatedEmail = mysqli_real_escape_string($conn, $_POST['updatedEmail']);

            // Update client details in the database
            $updateSql = "UPDATE coffee_data SET 
                          customer_name = '$updatedName', 
                          phone_number = '$updatedPhoneNumber', 
                          email = '$updatedEmail' 
                          WHERE id = $clientId";

if ($conn->query($updateSql) === TRUE) {
    // JavaScript alert and redirect on successful update
    echo "<script>
            alert('Client details updated successfully');
            window.location.href = 'clients.php';
          </script>";
    exit();
} else {
    // JavaScript alert and redirect on update failure
    echo "<script>
            alert('Error updating client details: " . $conn->error . "');
            window.location.href = 'clients.php';
          </script>";
}

        }
    } else {
        echo "Client not found";
    }
} else {
    echo "Client ID not provided";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client - CoffeeOps Manager</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <nav>
        
        <a href="#">Home</a>
        <a href="#">Products</a>
        <a href="#">Orders</a>
        <a href="#">Reports</a>
        <!-- Your navigation links here -->
    

        <?php if(isset($_SESSION['name'])): ?>
            <span style="color: #ffffff; font-weight: bold;">Welcome, <?php echo $_SESSION['name']; ?>!</span>
            <a href="logout.php" style="color: #ffffff; font-weight: bold;">Logout</a>
        <?php else: ?>
            <a href="login.php" style="color: #ffffff; font-weight: bold;">Login</a>
        <?php endif; ?>
    </nav>

    <div class="container mt-5">
        <h1>Edit Client Details</h1>

        <?php if ($result && $result->num_rows > 0): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="updatedName">Name:</label>
                    <input type="text" class="form-control" id="updatedName" name="updatedName" value="<?php echo $row['customer_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="updatedPhoneNumber">Phone Number:</label>
                    <input type="tel" class="form-control" id="updatedPhoneNumber" name="updatedPhoneNumber" value="<?php echo $row['phone_number']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="updatedEmail">Email:</label>
                    <input type="email" class="form-control" id="updatedEmail" name="updatedEmail" value="<?php echo $row['email']; ?>">
                </div>

                <button type="submit" class="btn btn-primary">Update Details</button>
            </form>
        <?php else: ?>
            <p>No client found.</p>
        <?php endif; ?>

    </div>

</body>
</html>
