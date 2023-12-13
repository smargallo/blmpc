<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $extension = $_POST['extension'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $pob = $_POST['pob'];
    $civil_status = $_POST['civil-status'];
    $tin = $_POST['tin'];
    $mobile_number = $_POST['mobile-number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $brgy = $_POST['brgy'];
    $municipality = $_POST['municipality'];
    $province = $_POST['province'];
    $region = $_POST['region'];
    $status = $_POST['status'];

    if (!empty($_FILES['image']['name'])) {
        $imageFileName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));

        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $uploadDir = 'uploads/';
            $imageFile = $uploadDir . uniqid() . '.' . $imageFileType;

            if (move_uploaded_file($imageTmpName, $imageFile)) {
                $sql = "UPDATE `members_tbl` SET `firstname`='$firstname',`middlename`='$middlename',`lastname`='$lastname',`extension`='$extension',`dob`='$dob',`age`='$age',`pob`='$pob',`civil_status`='$civil_status',`tin`='$tin',`mobile_number`='$mobile_number',`email`='$email', `address`='$address',`brgy`='$brgy',`municipality`='$municipality',`province`='$province',`image_path`='$imageFile',  `status`='$status' WHERE id = $member_id";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['success'] = "Member details have been updated!";
                } else {
                    $_SESSION['error'] = "Error updating member details: " . $conn->error;
                }
            } else {
                $_SESSION['error'] = "Error uploading the new image.";
            }
        } else {
            $_SESSION['error'] = "Invalid image format. Allowed formats: JPG, JPEG, PNG, GIF.";
        }
    } else {
        $sql = "UPDATE `members_tbl` SET `firstname`='$firstname',`middlename`='$middlename',`lastname`='$lastname',`extension`='$extension',`dob`='$dob',`age`='$age',`pob`='$pob',`civil_status`='$civil_status',`tin`='$tin',`mobile_number`='$mobile_number',`email`='$email', `address`='$address',`brgy`='$brgy',`municipality`='$municipality',`province`='$province',`region`='$region', `status`='$status' WHERE id = $member_id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Member details have been updated!";
        } else {
            $_SESSION['error'] = "Error updating member details: " . $conn->error;
        }
    }

    header("Location: ../index.php");
    exit;
}
