<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    include 'connection.php';
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["fullname"] = $fullname;
        header("Location: ../dashboard.php");
    } else {
        header("Location: ../login.php?error=1");
    }

    $conn->close();
}
?>
