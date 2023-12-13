<?php include('headers.php') ?>
<?php include('sidebar.php') ?>
<?php include('connection.php') ?>
    <?php 
    session_start();
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $member_id = $_GET["id"];
        
            $sql = "SELECT * FROM members_tbl WHERE id=$member_id";
            $result = $conn->query($sql);
        
            $row = $result->fetch_assoc();
        }
    ?>
     <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
                    $member_id = $_GET["id"];

                    $sql = "DELETE FROM members_tbl WHERE id=$member_id";
                    

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['success'] = "Member deleted successfully!";
                    }
                    header("Location: ../index.php");
                    exit;
                }
                ?>