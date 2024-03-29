<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['name'])) {
    header('location: auth/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoffeeOps Manager</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Set a light background color */
        }

        .container {
            background-color: #ffffff; /* Set a white background color for the form container */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow */
            max-width: 800px;
            margin: 0 auto; /* Center the container */
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #343a40; /* Set a dark text color */
        }

        nav {
            background-color: #007bff; /* Set a primary color for the navigation bar */
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center; /* Center the links */
        }

        nav a {
            color: #ffffff; /* Set a white text color for navigation links */
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .profile {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #ffffff;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <nav>
        <a href="index.php">Home</a>
        <a href="clients.php">View customers</a>
        <a href="#">Orders</a>
        <a href="#">Reports</a>
        <!-- Add more links as needed -->

        <?php if(isset($_SESSION['name'])): ?>
            <!-- Display the admin profile if logged in -->
            <span class="profile">Welcome, <?php echo $_SESSION['name']; ?>!</span>
        <?php else: ?>
            <!-- Display the login link if not logged in -->
            <a href="login.php" style="color: #ffffff; font-weight: bold;">Login</a>
        <?php endif; ?>
    </nav>
    <div class="container">
        <h1>Welcome to CoffeeOps Manager</h1>
        <form id="coffeeForm" action="saveData.php" method="post">
            <!-- Your form fields go here -->
            <div class="form-group">
                <label for="customerName">Customer Name:</label>
                <input type="text" class="form-control" id="customerName" name="customerName" required>
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number:</label>
                <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" required>
            </div>
            <div class="form-group">
                <label for="email">Email (optional):</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address"></textarea>
            </div>
            <div class="form-group">
                <label for="customerPhoto">Customer Photo:</label>
                <input type="file" class="form-control-file" id="customerPhoto" name="customerPhoto">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>
    </div>
    <script src="script.js"></script>

</body>
</html>
