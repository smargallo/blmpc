<?php
session_start();
include('connection.php');

if (isset($_GET['type']) && $_GET['type'] === 'excel') {
    $sql = "SELECT `id`, `firstname`, `middlename`, `lastname`, `extension`, `dob`, `age`, `pob`, `civil_status`, `tin`, `mobile_number`, `email`, `brgy`, `municipality`, `province`, `status` FROM `members_tbl` WHERE 1";
    $result = $conn->query($sql);
    
    $csvData = "BLMPC Members\n";
    $csvData .= "ID,First Name,Middle Name,Last Name,Extension,Date of Birth,Age,Place of Birth,Civil Status,TIN,Mobile Number,Email,Barangay,Municipality,Province,Status\n"; // Column headers
    while ($row = $result->fetch_assoc()) {
        $csvData .= "{$row['id']},{$row['firstname']},{$row['middlename']},{$row['lastname']},{$row['extension']},{$row['dob']},{$row['age']},{$row['pob']},{$row['civil_status']},{$row['tin']},{$row['mobile_number']},{$row['email']},{$row['brgy']},{$row['municipality']},{$row['province']},{$row['status']}\n";
    }
    
    header('Content-Type: text/csv');
    $filename = "BLMPC-MembersGenerated_" . date('Y-m-d') . ".csv";
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo $csvData;
    exit;
}

$conn->close();
?>
