<?php
include("functions/connection.php");

// Query to fetch event dates and titles from the database
$sql = "SELECT * FROM events_tbl";
$result = $conn->query($sql);

$eventData = [];

// while ($row = $result->fetch_assoc()) {
//     // Store the event data with the date as the key and title as the value
//     $eventData[$row['event_date']] = $row['event_name'];
// }

while ($row = $result->fetch_assoc()) {
    // Store the event data with the date as the key and an array of title and description as the value
    $eventData[$row['event_date']] = array(
        'title' => $row['event_name'],
        'description' => $row['event_description'],
        'image_path' => $row['image_path'],
        'date' => $row['event_date'],
        'link' => $row['google_calendar_link'],
    );
}

// Return the event data as JSON
header('Content-Type: application/json');
echo json_encode($eventData);

