<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_date = $_POST['event_date'];
    $outputDate = date('Y/m/d', strtotime($event_date));
    $event_name = $_POST['event_name'];
    $event_description = $_POST['event_description'];

    $dateCheckQuery = "SELECT COUNT(*) AS event_count FROM events_tbl WHERE event_date = '$event_date'";
    $dateResult = $conn->query($dateCheckQuery);

    if ($dateResult) {
        $eventCount = $dateResult->fetch_assoc()['event_count'];
        if ($eventCount > 0) {
            $_SESSION['error'] = "An event already exists for the selected date.";
        } else {
            $sql = "INSERT INTO events_tbl(event_name, event_date, event_description) VALUES('$event_name', '$event_date', '$event_description')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = "New Event Added!";
            } else {
                $_SESSION['error'] = "Error: " . $conn->error;
            }
        }
    }

    header("Location: ../events.php");
    exit;
}
?>