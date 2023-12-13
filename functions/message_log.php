<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (empty($email) || empty($username) || empty($password)) {
        $_SESSION['error'] = "Please fill in all required fields.";
    } else {
        $emailCheckQuery = "SELECT COUNT(*) AS email_count FROM users WHERE email_address = '$email'";
        $usernameCheckQuery = "SELECT COUNT(*) AS username_count FROM users WHERE username = '$username'";
        $emailResult = $conn->query($emailCheckQuery);
        $usernameResult = $conn->query($usernameCheckQuery);

        if ($emailResult && $usernameResult) {
            $emailCount = $emailResult->fetch_assoc()['email_count'];
            $usernameCount = $usernameResult->fetch_assoc()['username_count'];

            if ($emailCount > 0) {
                $_SESSION['error'] = "Email already exists. Please use a different email.";
            } elseif ($usenameCount > 0) {
                $_SESSION['error'] = "Username already exists. Please use a different username.";
            } else {

                $sql = "INSERT INTO users (email_address, username, password, type) 
                                    VALUES ('$email', '$username', '$password', '$type')";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['success'] = "New User Added!";
                } else {
                    $_SESSION['error'] = "Error: " . $conn->error;
                }
            }
        }
    }

    header("Location: ../dashboard.php");
    exit;
}
