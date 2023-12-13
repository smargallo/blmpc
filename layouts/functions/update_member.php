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
    $brgy = $_POST['brgy'];
    $municipality = $_POST['municipality'];
    $province = $_POST['province'];
    $status = $_POST['status'];

    $sql = "UPDATE `members_tbl` SET `firstname`='$firstname',`middlename`='$middlename',`lastname`='$lastname',`extension`='$extension',`dob`='$dob',`age`='$age',`pob`='$pob',`civil_status`='$civil_status',`tin`='$tin',`mobile_number`='$mobile_number',`email`='$email',`brgy`='$brgy',`municipality`='$municipality',`province`='$province', `status`='$status' WHERE id = $member_id";


    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Member details have been updated!";
    }


    header("Location: ../index.php");
    exit;
}
