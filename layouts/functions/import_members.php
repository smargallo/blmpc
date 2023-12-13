<?php
session_start();
if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
    $csvFile = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($csvFile, 'r');
    include('connection.php');

    while (($data = fgetcsv($handle, 0, ',')) !== false) {
        if (empty(array_filter($data))) {
            continue; // Skip empty rows
        }
        
        // Generate a new unique mem_id for each member
        $random_number = rand(1000, 9999);
        $currDate = date("Ymd");
        $mem_id = $currDate . $random_number;
    
        // Prepare and execute the SQL insert query
        $sql = "INSERT INTO members_tbl (mem_id, firstname, middlename, lastname, extension, dob, age, pob, civil_status, tin, mobile_number, email, brgy, municipality, province, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
    
        // Adjust the bind_param line to include $mem_id
        $stmt->bind_param("ssssssssssssssss", $mem_id, ...$data);
        $stmt->execute();
    }
    
    fclose($handle);
    $conn->close();
    header('Location: ../index.php?success=1');
    $_SESSION['success'] = "Importing members run successfully!";
    exit;
} else {
    header('Location: ../index.php?error=1');
    $_SESSION['success'] = "Importing members run failed!";
    exit;
}
?>
