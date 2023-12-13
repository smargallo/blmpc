<?php

session_start();
include('connection.php');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Perform the query
$query = "SELECT `id`, `mem_id`, `firstname`, `middlename`, `lastname`, `extension`, `dob`, `age`, `pob`, `civil_status`, `tin`, `mobile_number`, `email`, `address`, `brgy`, `municipality`, `province`, `region`, `image_path`, `status` FROM `members_tbl` WHERE 1";

$result = $conn->query($query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Set the CSV header
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="members_export_' . date('Ymd_His') . '.csv"');


// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, array('id', 'mem_id', 'firstname', 'middlename', 'lastname', 'extension', 'dob', 'age', 'pob', 'civil_status', 'tin', 'mobile_number', 'email', 'address', 'brgy', 'municipality', 'province', 'region', 'image_path', 'status'));

// Output the data
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

// Close the database connection
$conn->close();

// Close the file pointer
fclose($output);

?>
