<?php include('layouts/headers.php') ?>
<?php include('layouts/sidebar.php') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div id="content-wrapper" class="d-flex flex-column">
    <?php include('layouts/topbar.php') ?>
    <div class="container-fluid m-3">
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

        <div class="row">
            <div class="col-5">
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
            <div class="col-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">Admin Accounts</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="accTbl" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Email Address</th>
                                        <th>Username</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include('functions/connection.php');
                                    $itemsPerPage = 10;
                                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $startIndex = ($currentPage - 1) * $itemsPerPage;

                                    $sqlActiveMembers = "SELECT * FROM users LIMIT $startIndex, $itemsPerPage";
                                    $resultActiveMembers = $conn->query($sqlActiveMembers);

                                    while ($row = $resultActiveMembers->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><?= $row['email_address'] ?></td>
                                            <td><?= $row['username'] ?></td>
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

        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Members</h6>
            </div>
            <div class="card-body">
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
                            $itemsPerPage = 10;
                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                            $startIndex = ($currentPage - 1) * $itemsPerPage;

                            $sqlInactiveMembers = "SELECT * FROM members_tbl LIMIT $startIndex, $itemsPerPage";
                            $resultInactiveMembers = $conn->query($sqlInactiveMembers);

                            while ($row = $resultInactiveMembers->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= $row['firstname'] ?></td>
                                    <td><?= $row['middlename'] ?></td>
                                    <td><?= $row['lastname'] ?></td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 'active') {
                                        ?>
                                            <div class="btn btn-sm" id="active-btn">Active</div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="btn btn-sm" id="inactive-btn">Inactive</div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Chart.js code for the Donut Chart
    var ctxPie = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Active Members', 'Inactive Members'],
            datasets: [{
                data: [<?php echo $activeCount; ?>, <?php echo $inactiveCount; ?>],
                backgroundColor: ['rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)'],
            }],
        },
    });
</script>
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