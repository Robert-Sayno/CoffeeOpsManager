<?php
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
    <title>Welcome to CoffeeOps Manager</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        header {
            background-color: #3f51b5;
            color: #ffffff;
            padding: 20px;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav {
            background-color: #3949ab;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #c5cae9;
        }

        section {
            text-align: center;
            margin: 50px 0;
        }

        h1 {
            color: #3f51b5;
            font-size: 3em;
            margin-bottom: 10px;
        }

        p {
            color: #546e7a;
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .cta-button {
            background-color: #3f51b5;
            color: #ffffff;
            padding: 15px 30px;
            font-size: 1.2em;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #5c6bc0;
        }
    </style>
</head>
<body>

    <header>
        <h1>Welcome to CoffeeOps Manager</h1>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="add_clients.php">Add clients</a>
        <a href="clients.php">View all clients</a>
        <a href="#">Reports</a>
        <!-- Add more links as needed -->

        <?php if(isset($_SESSION['name'])): ?>
            <!-- Display the admin profile if logged in -->
            <span style="color: #ffffff; font-weight: bold;">Welcome, <?php echo $_SESSION['name']; ?>!</span>
        <?php else: ?>
            <!-- Display the login link if not logged in -->
            <a href="auth/logout.php" style="color: #ffffff; font-weight: bold;">Logout</a>
        <?php endif; ?>
    </nav>

    <section>
        <h1>Your Coffee Management Solution</h1>
        <p>Efficiently manage your clients, orders, and reports with CoffeeOps Manager.</p>
        <a href="clients.php" class="cta-button">Get Started</a>
    </section>

</body>
</html>
