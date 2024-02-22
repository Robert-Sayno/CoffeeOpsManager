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

$client_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch specific client data for editing
$sql = "SELECT * FROM coffee_data WHERE id = $client_id";
$result = $conn->query($sql);

// Fetch client details from the client_details table for the selected client
$clientDetailsSql = "SELECT * FROM client_details WHERE client_id = $client_id";
$clientDetailsResult = $conn->query($clientDetailsSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <!-- Add your head content here -->
    <style>
        /* Add your custom styles here */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .date-picker {
            width: calc(100% - 20px);
        }

        .add-details-form {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <nav>
        <a href="index.php">Home</a>
        <a href="clients.php">View clients</a>
        <a href="#">Orders</a>
        <a href="#">Reports</a>
        <!-- Your navigation links here -->
    </nav>

    <div class="container mt-5">
        <h2>Clients Details</h2>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php $row = $result->fetch_assoc(); ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Coffee Brought (kg)</th>
                        <th>Output (kg)</th>
                        <th>Residue (kg)</th>
                        <th>Unit Price</th>
                        <th>Total Amount Paid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($clientDetailsRow = $clientDetailsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $clientDetailsRow['date']; ?></td>
                            <td><?php echo $clientDetailsRow['coffee_brought']; ?></td>
                            <td><?php echo $clientDetailsRow['output']; ?></td>
                            <td><?php echo $clientDetailsRow['residue']; ?></td>
                            <td><?php echo $clientDetailsRow['unit_price']; ?></td>
                            <td><?php echo $clientDetailsRow['total_amount_paid']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="add-details-form">
                <h3>Add Details</h3>
                <form action="process_form.php" method="post">
                    <input type="hidden" name="client_id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="coffeeBrought">Coffee Brought (kg):</label>
                        <input type="number" name="coffeeBrought" id="coffeeBrought" required>
                    </div>
                    <!-- ... (rest of the form) ... -->
                    <button type="submit">Add Details</button>
                </form>
            </div>
        <?php endif; ?>

        <p>No clients found.</p>
    </div>

</body>
</html>
