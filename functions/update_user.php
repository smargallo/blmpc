<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function generateRandomPassword($length = 8)
    {
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';

        $allChars = $lowercase . $uppercase . $numbers;

        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($allChars) - 1);
            $password .= $allChars[$randomIndex];
        }

        return $password;
    }

    $randomPassword = generateRandomPassword();
    $user_id = $_POST['user_id'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $randomPassword;
    $type = "admin";

    if (empty($email) || empty($username) || empty($password)) {
        $_SESSION['error'] = "Please fill in all required fields.";
    } else {

        $sql = "UPDATE `users` SET `email_address`='$email',`username`='$username',`password`='$password' WHERE id = $user_id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "User updated!";
        } else {
            $_SESSION['error'] = "Error: " . $conn->error;
        }
    }

    header("Location: ../dashboard.php");
    exit;
}
