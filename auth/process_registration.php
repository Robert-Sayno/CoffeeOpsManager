<?php
session_start();
include_once('connection.php');
include_once('auth_functions.php');

// Check if the 'register' key is set in the POST request.
if(isset($_POST['register']))
{
    // Retrieve user input from the POST request.
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if the password and confirm password match.
    if ($password !== $confirmPassword) {
        // Set an error message in the session.
        $_SESSION['error'] = 'Passwords do not match';
        // Redirect back to the signup page with an error message.
        header('location:signup.php');
        exit();
    }

    // Check if the username already exists in the 'admins' table.
    $checkUsernameQuery = "SELECT * FROM `admins` WHERE `username`='$username'";
    $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);

    if(mysqli_num_rows($checkUsernameResult) > 0) {
        // Set an error message in the session.
        $_SESSION['error'] = 'Username already exists';
        // Redirect back to the signup page with an error message.
        header('location:signup.php');
        exit();
    }

    // Hash the password using password_hash for secure password hashing.
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert user information into the 'admins' table.
    $sql = "INSERT INTO `admins`(`name`, `username`, `password`) VALUES ('$name','$username','$hashedPassword')";
    
    // Execute the SQL query.
    $result = mysqli_query($conn, $sql);
    
    // Check if the query was successful.
    if($result) {
        // Redirect the user to the 'index.php' page upon successful registration.
        header('location:../index.php');
        // Display a JavaScript alert notifying the user of successful registration.
        echo "<script>alert('New User Register Success');</script>";   
    } else {
        // If the query fails, display the MySQL error and terminate the script.
        die(mysqli_error($conn));
    }
}
?>
