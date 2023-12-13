<?php include('headers.php') ?>
<?php include('sidebar.php') ?>
<?php include('connection.php') ?>
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $user_id = $_GET["id"];

        $sql = "SELECT * FROM users WHERE id = $user_id";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
    }
    ?>
     <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $user_id = $_GET["id"];

            $sql = "DELETE FROM users WHERE id=$user_id";


            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = "User deleted successfully!";
            }
            header("Location: ../dashboard.php");
            exit;
        }
        ?>