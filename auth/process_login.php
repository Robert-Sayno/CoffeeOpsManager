<?php
session_start();
include_once('connection.php');
include_once('auth_functions.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to select user from 'admins' table using prepared statement
    $sql = "SELECT * FROM `admins` WHERE `username`=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION['error'] = 'Please fill both Username and Password';
    } else {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $hashedPassword = $row['password'];

            // Verify the password using password_verify
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['name'] = $name;
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $hashedPassword; // You might not need to store the password in the session.

                header('location:../index.php');
                exit;
            } else {
                $_SESSION['error'] = 'Invalid Password';
            }
        } else {
            $_SESSION['error'] = 'Invalid Username';
        }
    }

    // Redirect back to the login page with error message
    header('location:login.php');
    exit;
}
?>
