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

// Fetch all client data for display
$sqlAllClients = "SELECT * FROM coffee_data";
$resultAllClients = $conn->query($sqlAllClients);

// Fetch specific client data for editing
$sql = "SELECT * FROM coffee_data WHERE id = $client_id";
$result = $conn->query($sql);

// Insert client details into the client_details table
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $coffeeBrought = $_POST['coffeeBrought'];
    $output = $_POST['output'];
    $residue = $_POST['residue'];
    $unitPrice = $_POST['unitPrice'];
    $totalAmountPaid = $_POST['totalAmountPaid'];
    $date = date("Y-m-d");

    $insertSql = "INSERT INTO client_details (client_id, date, coffee_brought, output, residue, unit_price, total_amount_paid) 
                  VALUES ($client_id, '$date', $coffeeBrought, $output, $residue, $unitPrice, $totalAmountPaid)";

    if ($conn->query($insertSql) === TRUE) {
        echo "Details added successfully";
    } else {
        echo "Error adding details: " . $conn->error;
    }
}

$conn->close();
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

        <!-- Display all client names -->
        <ul>
            <?php while ($rowAllClients = $resultAllClients->fetch_assoc()): ?>
                <li><?php echo $rowAllClients['name']; ?></li>
            <?php endwhile; ?>
        </ul>

        <?php if ($resultAllClients && $resultAllClients->num_rows > 0): ?>
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
                    <?php while ($rowAllClients = $resultAllClients->fetch_assoc()): ?>
                        <?php
                        // Fetch client details from the client_details table for the current client
                        $clientDetailsSql = "SELECT * FROM client_details WHERE client_id = " . $rowAllClients['id'];
                        $clientDetailsResult = $conn->query($clientDetailsSql);
                        ?>
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
                    <?php endwhile; ?>
                </tbody>
            </table>

           <!-- ... (previous code) ... -->

           <?php if ($result && $result->num_rows > 0): ?>
                <?php $row = $result->fetch_assoc(); ?>
                <div class="add-details-form">
                    <h3>Add Details</h3>
                    <form action="clients.php" method="post">
                        <input type="hidden" name="client_id" value="<?php echo $row['id']; ?>">
                        <div class="form-group">
                            <label for="coffeeBrought">Coffee Brought (kg):</label>
                            <input type="number" name="coffeeBrought" id="coffeeBrought" required>
                        </div>
                        <div class="form-group">
                            <label for="output">Output (kg):</label>
                            <input type="number" name="output" id="output" required>
                        </div>
                        <div class="form-group">
                            <label for="residue">Residue (kg):</label>
                            <input type="number" name="residue" id="residue" required>
                        </div>
                        <div class="form-group">
                            <label for="unitPrice">Unit Price:</label>
                            <input type="number" name="unitPrice" id="unitPrice" required>
                        </div>
                        <div class="form-group">
                            <label for="totalAmountPaid">Total Amount Paid:</label>
                            <input type="number" name="totalAmountPaid" id="totalAmountPaid" required>
                        </div>
                        <!-- Add other input fields as needed -->
                        <button type="submit">Add Details</button>
                    </form> <!-- Add this closing tag -->
                </div>
            <?php endif; ?>

        <!-- ... (remaining code) ... -->

            <p>No clients found.</p>
        <?php endif; ?>

    </div>

</body>
</html>
