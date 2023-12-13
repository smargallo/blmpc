<?php include('layouts/headers.php') ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- script para sa sweet alert -->
<script>
    function displaySuccessMessage(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: message,
            confirmButtonText: 'OK'
        });
    }

    function displayErrorMessage(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonText: 'OK'
        });
    }
</script>
<!-- end of script -->


<!-- error and success message -->
<?php
if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
    $successMessage = $_SESSION['success'];
    unset($_SESSION['success']);
    echo '<script>displaySuccessMessage("' . $successMessage . '");</script>';
} else if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
    echo '<script>displayErrorMessage("' . $errorMessage . '");</script>';
}
?>
<!-- end of alert -->

<!-- main row -->
<div class="row m-2">
    <!-- chart -->
    <div class="col-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Member Chart</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 mx-auto" style="width: 300px; height: 300px;">
                    <canvas id="myPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- end of chart -->

    <!-- members table -->
    <div class="col-9">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Members</h6>
            </div>
            <div class="card-body">
                <div class="btn btn-sm" id="inactive-btn">

                </div> <span class="small">Inactive</span>
                <div class="btn btn-sm" id="active-btn">
                </div> <span class="small">Active</span>
                <div class="table-responsive">
                    <table class="table table-bordered" id="memTbl" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Middlename</th>
                                <th>Last Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('functions/connection.php');
                            $itemsPerPage = 100;
                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                            $startIndex = ($currentPage - 1) * $itemsPerPage;

                            $sqlInactiveMembers = "SELECT * FROM members_tbl";
                            $resultInactiveMembers = $conn->query($sqlInactiveMembers);

                            while ($row = $resultInactiveMembers->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= $row['firstname'] ?></td>
                                    <td><?= $row['middlename'] ?></td>
                                    <td><?= $row['lastname'] ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($row['status'] == 'active') {
                                        ?>
                                            <div class="btn btn-sm" id="active-btn"><i class="fa-solid fa-check-circle"></i></div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="btn btn-sm" id="inactive-btn"><i class="fa-solid fa-x"></i></div>
                                        <?php

                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }

                            $sqlInactiveCount = "SELECT COUNT(*) AS inactive_count FROM members_tbl WHERE status = 'inactive'";
                            $resultInactiveCount = $conn->query($sqlInactiveCount);
                            $inactiveCount = $resultInactiveCount->fetch_assoc()['inactive_count'];

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
    <!-- end of member table -->

</div>

<!-- another row -->
<div class="row m-2">
    <div class="row">
        <!-- admin accounts table -->
        <div class="col-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Admin Accounts</h6>
                </div>
                <div class="card-body">
                    <div class="col mb-3">
                        <a class="btn btn-success btn" data-toggle="modal" title="Add new admin account (Single Insertion)" data-target="#newUser"><i class="fa-solid fa-plus"></i> New Admin</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="accTbl" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email Address</th>
                                    <th>Username</th>
                                    <?php if ($_SESSION["type"] == "super_admin") {
                                    ?>
                                        <th>Password</th>
                                        <th>Action</th>
                                    <?php
                                    } ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('functions/connection.php');
                                $itemsPerPage = 10;
                                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                                $startIndex = ($currentPage - 1) * $itemsPerPage;

                                $sqlActiveMembers = "SELECT * FROM users WHERE type = 'admin' LIMIT $startIndex, $itemsPerPage";
                                $resultActiveMembers = $conn->query($sqlActiveMembers);

                                while ($row = $resultActiveMembers->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['email_address'] ?></td>
                                        <td><?= $row['username'] ?></td>
                                        <?php if ($_SESSION["type"] == "super_admin") {
                                        ?>
                                            <td><?= $row['password'] ?></td>
                                            <td>
                                                <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#updateModal<?= $row['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>

                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"><i class="fa-solid fa-trash"></i></a>

                                                <!-- delete admin modal -->
                                                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete this user?</h5>

                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <p>Deleting a user also remove it's data from database. Are you sure you want to continue?</p>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button class="btn btn-warning btn-sm" type="button" data-dismiss="modal">Cancel</button>
                                                                <a class="btn btn-danger btn-sm" href="./functions/delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end for delete admin modal -->

                                                <!-- modal for updating the user/admin -->
                                                <div class="modal fade" id="updateModal<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">UPDATE USER</h5>
                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="user" method="post" action="./functions/update_user.php" enctype="multipart/form-data">
                                                                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">

                                                                    <div class="mb-3">
                                                                        <label for="email" class="form-label">Email address</label>
                                                                        <input type="email" class="form-control" value="<?php echo $row['email_address'] ?>" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputPassword1" class="form-label">Username</label>
                                                                        <input type="text" class="form-control" value="<?php echo $row['username'] ?>" name="username" id="exampleInputPassword1">
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-warning btn-sm" type="button" data-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-sm btn-success">Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end for update admin modal -->
                                            </td>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                <?php
                                }

                                $sqlActiveCount = "SELECT COUNT(*) AS active_count FROM members_tbl WHERE status = 'active'";
                                $resultActiveCount = $conn->query($sqlActiveCount);
                                $activeCount = $resultActiveCount->fetch_assoc()['active_count'];

                                $sqlInactiveCount = "SELECT COUNT(*) AS inactive_count FROM members_tbl WHERE status = 'inactive'";
                                $resultInactiveCount = $conn->query($sqlInactiveCount);
                                $inactiveCount = $resultInactiveCount->fetch_assoc()['inactive_count'];

                                $conn->close();
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- end of member table -->

        <!-- events table -->
        <div class="col-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Events</h6>
                </div>
                <div class="card-body">
                    <div class="btn btn-sm" id="inactive-btn-event">

                    </div> <span class="small">Upcoming Event</span>
                    <div class="btn btn-sm" id="active-btn">
                    </div> <span class="small">Completed</span>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="memTbl" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('functions/connection.php');
                                $itemsPerPage = 10;
                                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                                $startIndex = ($currentPage - 1) * $itemsPerPage;

                                $sqlInactiveMembers = "SELECT * FROM events_tbl LIMIT $startIndex, $itemsPerPage";
                                $resultInactiveMembers = $conn->query($sqlInactiveMembers);

                                while ($row = $resultInactiveMembers->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td class="text-center"><img src="functions/<?php echo $row['image_path']; ?>" width="150" class="img" alt="Member Image"></td>
                                        <td><?= $row['event_name'] ?></td>
                                        <td><?= $row['event_date'] ?></td>
                                        <td class="text-center">

                                            <?php
                                            $eventDate = new DateTime($row['event_date']);
                                            $currentDate = new DateTime();
                                            if ($eventDate < $currentDate) {
                                            ?>
                                                <div class="btn btn-sm" id="active-btn">
                                                    <i class="fa-solid fa-check-circle" title="Completed Event"></i>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="btn btn-sm" id="inactive-btn-event" title="Upcoming Event">
                                                    <i class="fa-solid fa-calendar" title="Upcoming Event"></i>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>


                                <?php
                                }

                                $sqlInactiveCount = "SELECT COUNT(*) AS inactive_count FROM members_tbl WHERE status = 'inactive'";
                                $resultInactiveCount = $conn->query($sqlInactiveCount);
                                $inactiveCount = $resultInactiveCount->fetch_assoc()['inactive_count'];

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- end of events table -->
</div>

<!-- modal for adding new admin -->
<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">NEW ADMIN ACCOUNT</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="functions/add_user.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="exampleInputPassword1">
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end of add admin modal -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- script for the donut chart -->
<script>
    // Chart.js code for the Donut Chart
    var ctxPie = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Active Members', 'Inactive Members'],
            datasets: [{
                data: [<?php echo $activeCount; ?>, <?php echo $inactiveCount; ?>],
                backgroundColor: ['rgba(0, 100, 0, 1)', 'rgba(255, 0, 0, 1)'],
            }],
        },
    });
</script>

<!-- script for datatables -->
<script>
    $(document).ready(function() {
        $('#accTbl').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        $('#memTbl').DataTable();
    });
</script>

<?php include('layouts/footer.php'); ?>