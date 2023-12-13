<?php include('layouts/headers.php') ?>
<?php include('layouts/sidebar.php') ?>

<!-- custom styling -->
<!-- end of custom styling -->

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content bg-dark">
        <?php include('layouts/topbar.php') ?>


        <div class="row">
            <div class="col-xl-10 mx-auto col-md-10 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row col-xl-6 col-md-12 mb-2 align-items-start">
                            <div class="col-1">
                                <a class="btn btn-success btn" data-toggle="modal" title="Add new Administrator (Single Insertion)" data-target="#newModal"><i class="fa-solid fa-plus"></i></a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <?php
                            include('functions/connection.php');
                            $sql = "SELECT * FROM members_tbl order by lastname ASC";
                            $result = $conn->query($sql);
                            $conn->close();
                            ?>

                            <p class="text-success h4">Admin Accounts</p>
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Member ID</th>
                                        <th class="text-center ">Name <span class="small">(lastname, firstname middlename)</span></th>
                                        <th class="text-center">Mobile Number</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Operation</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td class="text-center"><b class="text-success"><?= $row['mem_id'] ?></b></td>
                                            <td class="text-center"><?= $row['lastname'] ?>, <?= $row['firstname'] ?> <?= $row['middlename'] ?></td>
                                            <td class="text-center"><?= $row['mobile_number'] ?></td>
                                            <td class="text-center"><?= $row['status'] ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#updateModal<?= $row['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>

                                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"><i class="fa-solid fa-trash"></i></a>

                                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#viewModal<?= $row['id'] ?>"><i class="fa-solid fa-eye"></i></button>
                                            </td>
                                        </tr>

                                    <?php endwhile; ?>
                                </tbody>



                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include('layouts/footer.php') ?>