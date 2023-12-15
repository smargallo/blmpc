<?php
session_start();
include('connection.php');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize($data)
{
    global $conn;
    return $conn->real_escape_string($data);
}

$failedRows = [];

// Check if a file was uploaded
if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
    $file = $_FILES['csv_file']['tmp_name'];

    // Open the file for reading
    $handle = fopen($file, "r");

    $lastMemId = null;
    $isFirstRow = true;

    // Loop through the file line by line
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        if ($isFirstRow) {
            $isFirstRow = false;
            continue;
        }
 
        // Sanitize the data
        $id = sanitize($data[0]);
        $tin = sanitize($data[10]);
        $mobile_number = sanitize($data[11]);
        $email = sanitize($data[12]);

        // Check if a member with the same ID, mobile_number, or email already exists
        $checkExistingStmt = $conn->prepare("SELECT COUNT(*) FROM members_tbl WHERE id = ? OR mobile_number = ? OR email = ? OR tin = ?");
        $checkExistingStmt->bind_param("ssss", $id, $mobile_number, $email, $tin);
        $checkExistingStmt->execute();
        $checkExistingStmt->bind_result($count);
        $checkExistingStmt->fetch();
        $checkExistingStmt->close();

        // If a member with the same ID already exists, skip insertion
        if ($count > 0) {
            $failedRows[] = $data;
            continue;
        }

        // Sanitize the data
        $id = sanitize($data[0]);
        $mem_id = sanitize($data[1]);
        $firstname = sanitize($data[2]);
        $middlename = sanitize($data[3]);
        $lastname = sanitize($data[4]);
        $extension = sanitize($data[5]);
        $dob = sanitize($data[6]);
        $age = sanitize($data[7]);
        $pob = sanitize($data[8]);
        $civil_status = sanitize($data[9]);
        $tin = sanitize($data[10]);
        $mobile_number = sanitize($data[11]);
        $email = sanitize($data[12]);
        $address = sanitize($data[13]);
        $brgy = sanitize($data[14]);
        $municipality = sanitize($data[15]);
        $province = sanitize($data[16]);
        $region = sanitize($data[17]);
        $image_path = sanitize($data[18]);
        $status = sanitize($data[19]);

        // Get the last entry's mem_id
        $getLastIdStmt = $conn->prepare("SELECT MAX(mem_id) FROM members_tbl");
        $getLastIdStmt->execute();
        $getLastIdStmt->bind_result($lastMemId);
        $getLastIdStmt->fetch();
        $getLastIdStmt->close();

        // Increment the last mem_id for the new entry
        $mem_id = $lastMemId !== null ? (int)$lastMemId + 1 : 1;

        // Insert data into the database
        $query = "INSERT INTO `members_tbl` (`id`, `mem_id`, `firstname`, `middlename`, `lastname`, `extension`, `dob`, `age`, `pob`, `civil_status`, `tin`, `mobile_number`, `email`, `address`, `brgy`, `municipality`, `province`, `region`, `image_path`, `status`) 
                    VALUES ('$id', '$mem_id', '$firstname', '$middlename', '$lastname', '$extension', '$dob', '$age', '$pob', '$civil_status', '$tin', '$mobile_number', '$email', '$address', '$brgy', '$municipality', '$province', '$region', '$image_path', '$status')";

        try {
            $result = $conn->query($query);
            if (!$result) {
                throw new Exception("Query failed: " . $conn->error);
            }
        } catch (mysqli_sql_exception $ex) {
            // Handle duplicate entry error
            header('Location: ../index.php?error=1');
            $_SESSION['error'] = "Importing members run failed! Duplicate entry found.";
            exit;
        }
    }

    // Close the file handle
    fclose($handle);
    // Append failed rows to the session
    $_SESSION['failedRows'] = $failedRows;

    // Check if there were any failed rows
    if (!empty($failedRows)) {
        header('Location: ../index.php?error=1');
        $_SESSION['success'] = "Importing members run partially failed! Duplicate entries found in some rows.";
        exit;
    } else {
        header('Location: ../index.php?success=1');
        $_SESSION['success'] = "Importing members run successfully!";
        exit;
    }
} else {
    header('Location: ../index.php?error=1');
    $_SESSION['error'] = "Importing members run failed!";
    exit;
}
