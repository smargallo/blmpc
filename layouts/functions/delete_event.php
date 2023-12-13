<?php include('headers.php') ?>
<?php include('sidebar.php') ?>
<?php include('connection.php') ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">
    <?php include('topbar.php') ?>


    <?php 
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $event_id = $_GET["id"];
        
            $sql = "SELECT * FROM events_tbl WHERE id=$event_id";
            $result = $conn->query($sql);
        
            $row = $result->fetch_assoc();
        }
    ?>

     <!-- delete member -->
     <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
                    $member_id = $_GET["id"];

                    $sql = "DELETE FROM events_tbl WHERE id=$member_id";
                    $conn->query($sql);

                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['success'] = "Event deleted successfully!";
                    }
                    header("Location: ../events.php");
                    exit;
                }
                ?>

    <div class="card col-xl-3 mx-auto col-md-3 col-sm-4 border-2 shadow shadow-lg">
        <div class="card-body">

            <p class="h4 text-dark text-center">EVENT REMOVED FROM LIST</p>

            <div class="mx-auto col-3 p-2">
            <a href="events.php" class="text-center btn-danger btn btn-sm mx-auto col-10">OKAY</a>
            </div>
        </div>
    </div>
    
</div>
</div>
    
<?php include('footer.php') ?>