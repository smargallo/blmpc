<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userCheckQuery = "SELECT COUNT(*) AS user_count FROM users WHERE type = 'super_admin'";
    $userResult = $conn->query($userCheckQuery);

    if ($userResult) {
        $userCount = $userResult->fetch_assoc()['user_count'];

        if ($userCount > 0) {
            $_SESSION['error'] = "Only one super admin user is allowed. You cannot register another.";
        } else {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $type = "super_admin";
            $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);

            if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
                $_SESSION['error'] = "Please fill in all required fields.";
            } elseif ($password !== $confirmPassword) {
                $_SESSION['error'] = "Password and confirm password do not match.";
            } else {
                $sql = "INSERT INTO users (email_address, username, password, type) 
                                    VALUES ('$email', '$username', '$password', '$type')";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['registered_email'] = $email;
                    $_SESSION['registered_username'] = $username;
                    $_SESSION['registered_password'] = $password;
                    $_SESSION['registered_type'] = $type;
                    $_SESSION['success'] = "Admin Added!";
                } else {
                    $_SESSION['error'] = "Error: " . $conn->error;
                }
            }
        }
    }

    header("Location: ../login.php");
    exit;
} ?>
