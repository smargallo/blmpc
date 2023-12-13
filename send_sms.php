<?php
session_start();
require_once 'functions/connection.php';
require_once 'vendor/autoload.php'; // Path to the Nexmo PHP library

use Nexmo\Client;
//change ninyo base sa inyong api key 
// Your Nexmo API Key and API Secret
$nexmoApiKey = '86922296';
$nexmoApiSecret = 'vMYeM5dkxUOnTJlm';

$nexmo = new Client(new Nexmo\Client\Credentials\Basic($nexmoApiKey, $nexmoApiSecret));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST["message"];

    $sql = "SELECT mobile_number FROM members_tbl";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $phone_number =  $row["mobile_number"];

            $nexmo->message()->send([
                'to' => $phone_number,
                'from' => "+639975613995",
                'text' => $message,
            ]);

            $sql = "INSERT INTO sms_logs (message) VALUES('$message')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = "Announcement Sent";
                header("Location: events.php");
            } else {
                $_SESSION['error'] = "Error: " . $conn->error;
            }

            
            exit;
        }
    } else {
        echo "No recipients found.";
    }
}

$conn->close();
