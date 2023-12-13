<?php 
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $random_number = rand(1000, 9999);
    $currDate = date("Ymd");
    $mem_id = $currDate . $random_number;
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $extension = mysqli_real_escape_string($conn, $_POST['extension']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $pob = mysqli_real_escape_string($conn, $_POST['pob']);
    $civil_status = mysqli_real_escape_string($conn, $_POST['civil-status']);
    $tin = mysqli_real_escape_string($conn, $_POST['tin']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile-number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $brgy = mysqli_real_escape_string($conn, $_POST['brgy']);
    $municipality = mysqli_real_escape_string($conn, $_POST['municipality']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $region = mysqli_real_escape_string($conn, $_POST['region']);

    if (empty($firstname) || empty($lastname) || empty($dob) || empty($mobile_number) || empty($email)) {
        $_SESSION['error'] = "Please fill in all required fields.";
    } else {
        $emailCheckQuery = "SELECT COUNT(*) AS email_count FROM members_tbl WHERE email = '$email'";
        $mobileCheckQuery = "SELECT COUNT(*) AS mobile_count FROM members_tbl WHERE mobile_number = '$mobile_number'";
        
        $emailResult = $conn->query($emailCheckQuery);
        $mobileResult = $conn->query($mobileCheckQuery);

        if ($emailResult && $mobileResult) {
            $emailCount = $emailResult->fetch_assoc()['email_count'];
            $mobileCount = $mobileResult->fetch_assoc()['mobile_count'];

            if ($emailCount > 0) {
                $_SESSION['error'] = "Email already exists. Please use a different email.";
            } elseif ($mobileCount > 0) {
                $_SESSION['error'] = "Mobile number already exists. Please use a different mobile number.";
            } else {

                if (!empty($_FILES['image']['name'])) {
                    $imageFileName = $_FILES['image']['name'];
                    $imageTmpName = $_FILES['image']['tmp_name'];
                    $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));
                    
                    
                    if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $uploadDir = 'uploads/';
                        
                        $imageFile = $uploadDir . uniqid() . '.' . $imageFileType;
                        
                        if (move_uploaded_file($imageTmpName, $imageFile)) {
                            $sql = "INSERT INTO members_tbl (mem_id, firstname, middlename, lastname, extension, dob, age, pob, civil_status, tin, mobile_number, email, address, brgy, municipality, province, region, image_path) 
                                    VALUES ('$mem_id', '$firstname', '$middlename', '$lastname', '$extension', '$dob', '$age', '$pob', '$civil_status', '$tin', '$mobile_number', '$email', '$address', '$brgy', '$municipality', '$province', '$region', '$imageFile')";
                        
                            if ($conn->query($sql) === TRUE) {
                                $_SESSION['success'] = "New Member Added!";
                            } else {
                                $_SESSION['error'] = "Error: " . $conn->error;
                            }
                        } else {
                            $_SESSION['error'] = "Error uploading image.";
                        }
                    } else {
                        $_SESSION['error'] = "Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.";
                    }
                } else {
                    $_SESSION['error'] = "Please select an image.";
                }
            }
        }
    }

    header("Location: ../index.php");
    exit;
}
?>
