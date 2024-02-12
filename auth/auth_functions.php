<?php
// auth_functions.php

/**
 * Validate admin login credentials.
 *
 * @param string $username Admin username
 * @param string $password Admin password
 * @return bool True if credentials are valid, false otherwise
 */
function validateAdminLogin($username, $password)
{
    // Replace this with your actual database connection details
    $server = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $database = 'findhub';

    // Establish database connection
    $conn = new mysqli($server, $db_username, $db_password, $database);
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }

    // Fetch admin data from the database
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Valid credentials
            return true;
        }
    }

    // Invalid credentials
    return false;
}

/**
 * Hash a password using the default password_hash function.
 *
 * @param string $password Plain-text password
 * @return string Hashed password
 */
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}
?>
