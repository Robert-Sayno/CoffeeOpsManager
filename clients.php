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

// Fetch client data from the database
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Modify the SQL query to include search
$sql = "SELECT * FROM coffee_data
        WHERE customer_name LIKE '%$search%' OR phone_number LIKE '%$search%'";

$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoffeeOps Manager - Clients</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <nav>
        
        <a href="index.php">Home</a>
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
        <h1>Clients</h1>

        <!-- Add the search form at the top -->
        <form method="GET" action="clients.php" class="mb-3">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Search by name or phone number" name="search" value="<?php echo $search; ?>">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        <?php if ($result && $result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td>
                                <a href="edit_client.php?id=<?php echo $row['id']; ?>">Edit</a> |
                                <a href="delete_client.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a> |
                                <a href="manage_client.php?id=<?php echo $row['id']; ?>">Manage</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No clients found.</p>
        <?php endif; ?>

    </div>

</body>
</html>
