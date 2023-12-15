<?php include('layouts/headers.php') ?>


<?php
 
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["loggedin"] == NULL) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"];
?>

<?php
    if ($_SESSION["type"] == "super_admin") {
?>

<?php
}

?>

<div class="container-fluid">
    <h3 class="text-dark border-left-success p-3" style="font-weight: bold;"> MEMBER(S) MANAGEMENT</h3>
    <div class="d-sm-flex align-items-center mt-3 justify-space-between">

    </div>

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

    <div class="d-flex gap-2 mb-4">
        <div class="col-auto">
            <a class="btn btn-success btn" data-toggle="modal" title="Add new Member (Single Insertion)"
                data-target="#newMember"><i class="fa-solid fa-plus"></i></a>
        </div>

        <div class="col-auto">
            <button class="btn bg-primary text-white border-0 shadow-0" title="Import a CSV file" data-toggle="modal"
                data-target="#importModal"><i class="fa-solid fa-file-import"></i></button>
        </div>

        <div class="col-auto">
            <button class="btn bg-secondary text-white border-0 shadow-0" title="Download a CSV copy of data">
                <a href="./functions/export_members.php?type=excel" class="text-white"><i
                        class="fa-solid fa-cloud-arrow-down"></i></a>
            </button>
        </div>
    </div>

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

    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Members</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./functions/import_members.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="csv_file">Import .csv File</label>
                            <input type="file" name="csv_file" class="form-control-file btn btn-secondary" accept=".csv"
                                required>
                        </div>
                        <button type="submit" class="btn btn-success">Import Members</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="table-responsive">



                        <?php
                        include('functions/connection.php');
                        $sql = "SELECT * FROM members_tbl order by lastname ASC";
                        $result = $conn->query($sql);
                        $conn->close();
                        ?>

                        <p class="text-dark h4">MEMBERS LIST</p>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">Member ID</th>
                                    <th class="text-center">Profile Image</th>
                                    <th class="text-center ">Name <span class="small">(lastname, firstname
                                            middlename)</span></th>
                                    <th class="text-center">Age</th>
                                    <th class="text-center">Mobile Number</th>
                                    <th class="text-center">Address(Purok)</th>
                                    <th class="text-center">Brgy.</th>
                                    <th class="text-center">Municipality</th>
                                    <th class="text-center">Province</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Operation</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-left">
                                        <div class="d-flex align-items-center">
                                            <strong class="text-dark"><?= $row['mem_id'] ?></strong>
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <img src="<?= $row['image_path'] != '' ? "functions/" . $row['image_path'] : 'img/default-avatar.png' ?>"
                                            width="50" height="50" class="img-thumbnail" alt="Member Image"
                                            style="object-fit: cover;">
                                    </td>
                                    <td class="text-left">
                                        <?= $row['lastname'] ?>, <?= $row['firstname'] ?> <?= $row['middlename'] ?>
                                    </td>
                                    <td class="text-left">
                                        <?= $row['age'] ?>
                                    </td>
                                    <td class="text-left">
                                        <?= $row['mobile_number'] ?>
                                    </td>
                                    <td class="text-left">
                                        <?= $row['address'] ?>
                                    </td>
                                    <td class="text-left">
                                        <?= $row['brgy'] ?>
                                    </td>
                                    <td class="text-left">
                                        <?= $row['municipality'] ?>
                                    </td>
                                    <td class="text-left">
                                        <?= $row['province'] ?>
                                    </td>
                                    <td class="text-left">

                                        <div
                                            class="btn btn-sm <?= $row['status'] == 'active' ? 'btn-success' : 'btn-danger'; ?>">
                                            <?= ucfirst($row['status']); ?>
                                        </div>

                                    </td>
                                    <td class="text-left">

                                        <a class="btn btn-success btn-sm updateMemberBtn" data-toggle="modal"
                                            data-target="#updateModal<?= $row['id'] ?>" data-region="<?= $row['region'] ?>"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        <a class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal"><i class="fa-solid fa-trash"></i></a>

                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#viewModal<?= $row['id'] ?>"><i
                                                class="fa-solid fa-eye"></i></button>
                                    </td>
                                </tr>


                                <!-- Update Member Modal -->
                                <div class="modal fade edit" id="updateModal<?= $row['id'] ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">UPDATE MEMBER</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="user" method="post" action="./functions/update_member.php"
                                                    enctype="multipart/form-data">
                                                    <input type="hidden" name="member_id" value="<?= $row['id'] ?>">


                                                    <div class="row py-4">
                                                        <div class="col-lg-6 mx-auto">

                                                            <!-- Upload image input-->
                                                            <div
                                                                class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                                                <input id="uploadUp2" name="image" type="file"
                                                                    onchange="readURL2(this);"
                                                                    class="form-control border-0">
                                                                <!-- <label id="upload-label-up2" for="uploadUp2" class="font-weight-light text-muted">Choose file</label> -->
                                                                <div class="input-group-append">
                                                                    <label for="uploadUp"
                                                                        class="btn btn-light m-0 rounded-pill px-4"> <i
                                                                            class="fa fa-cloud-upload mr-2 text-muted"></i><small
                                                                            class="text-uppercase font-weight-bold text-muted">Choose
                                                                            file</small></label>
                                                                </div>
                                                            </div>

                                                            <!-- Uploaded image area-->
                                                            <p class="font-italic text-dark text-center">The image
                                                                uploaded will be rendered inside the box below.</p>
                                                            <div class="image-area mt-4"><img id="imageResultUp2"
                                                                    src="#" alt=""
                                                                    class="img-fluid rounded shadow-sm mx-auto d-block">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                    <script>
                                                        function readURL2(input) {
                                                            if (input.files && input.files[0]) {
                                                                var reader = new FileReader();

                                                                reader.onload = function (e) {
                                                                    $('#imageResultUp2').attr('src', e.target
                                                                        .result);
                                                                };
                                                                reader.readAsDataURL(input.files[0]);
                                                            }
                                                        }

                                                        $(function () {
                                                            $('#uploadUp2').on('change', function () {
                                                                readURL(this);
                                                            });
                                                        });

                                                        var input = document.getElementById('uploadUp2');
                                                        var infoArea = document.getElementById('upload-label-up2');

                                                        input.addEventListener('change', showFileName);

                                                        function showFileName(event) {
                                                            var input = event.srcElement;
                                                            var fileName = input.files[0].name;
                                                            infoArea.textContent = 'File name: ' + fileName;
                                                        }
                                                    </script>
                                                    <div class="row col-12 mx-auto">
                                                        <div class="form-group">
                                                            <label for="status">Member Status</label>
                                                            <select class="form-control form-select form-select-sm"
                                                                name="status">
                                                                <option value="<?php echo $row['status'] ?>">
                                                                    <?php echo $row['status'] ?></option>
                                                                <option value="active">active</option>
                                                                <option value="inactive">inactive</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-4">

                                                            <p class="text-dark small h5">Personal Details</p>
                                                            <div class="form-group">
                                                                <label for="firstname">Firstname</label>
                                                                <input id="updateFirstName" type="text" class="form-control form-control"
                                                                    value="<?= $row['firstname'] ?>" name="firstname"
                                                                    placeholder="First Name" oninput="capitalizeInput('updateFirstName')">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="middlename">Middle Name</label>
                                                                <input id="updateMiddleName" type="text" class="form-control form-control"
                                                                    name="middlename" value="<?= $row['middlename'] ?>"
                                                                    placeholder="Middle Name" oninput="capitalizeInput('updateMiddleName')">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="lastname">Lastname</label>
                                                                <input id="updateLastName" type="text" class="form-control form-control"
                                                                    value="<?= $row['lastname'] ?>" name="lastname"
                                                                    placeholder="Last Name" oninput="capitalizeInput('updateLastName')">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="extension">Suffix (optional)</label>
                                                                <select class="form-control form-select form-select-sm"
                                                                    name="extension">
                                                                    <option value="<?php echo $row['extension'] ?>">
                                                                        <?php echo $row['extension'] ?></option>
                                                                    <option value="N/A">None</option>
                                                                    <option value="Sr.">Sr</option>
                                                                    <option value="Jr.">JR</option>
                                                                    <option value="I">I</option>
                                                                    <option value="I">II</option>
                                                                    <option value="I">III</option>
                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div class="col-4">
                                                            <p class="text-dark small h5">Basic Information</p>
                                                            <div class="form-group">
                                                                <label for="dob">Date of Birth</label>
                                                                <input type="date" class="form-control form-control"
                                                                    value="<?= $row['dob'] ?>" name="dob">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="age">Age</label>
                                                                <input type="number" class="form-control form-control"
                                                                    name="age" value="<?= $row['age'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="pob">Place of Birth</label>
                                                                <input type="text" class="form-control form-control"
                                                                    value="<?= $row['pob'] ?>" name="pob"
                                                                    placeholder="Place of Birth">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="civil-status">Civil Status</label>
                                                                <select class="form-control form-select form-select-sm"
                                                                    name="civil-status">
                                                                    <option value="<?php echo $row['civil_status'] ?>">
                                                                        <?php echo $row['civil_status'] ?></option>
                                                                    <option value="Single">Single</option>
                                                                    <option value="Married">Married</option>
                                                                    <option value="Widowed">Widowed</option>
                                                                    <option value="Divorced">Divorced</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="tin">TIN</label>
                                                                <input type="number" class="form-control" name="tin" autocomplete="off"
                                                                    value="<?= $row['tin'] ?>" placeholder="TIN number">
                                                            </div>
                                                        </div>

                                                        <div class="col-4">
                                                            <p class="text-dark small h5 mb-6">Contact Information</p>
                                                            <div class="form-group">
                                                                <label for="mobile-number">Mobile Number</label>
                                                                <input type="number" class="form-control"
                                                                    value="<?= $row['mobile_number'] ?>"
                                                                    name="mobile-number" placeholder="Mobile">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email">Email Address</label>
                                                                <input type="email" class="form-control" name="email"
                                                                    value="<?= $row['email'] ?>"
                                                                    placeholder="Email Address">
                                                            </div>


                                                            <p class="text-dark small h5 mt-3">Address</p>
                                                            <div class="form-group">
                                                                <label for="province">Region</label>
                                                                <select name="region" class="form-control">
                                                                     
                                                                </select>

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="province">Province</label>
                                                                <!-- <input type="text" class="form-control form-control" name="province" value="<?= $row['province'] ?>" placeholder="Province"> -->

                                                                <select name="province" class="form-control">
                                                                    <option value="<?= $row['province'] ?>">
                                                                        <?= $row['province'] ?></option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="municipality">Municipality</label>
                                                                <!-- <input type="text" class="form-control form-control" name="municipality" value="<?= $row['municipality'] ?>" placeholder="Municipality"> -->
                                                                <select name="municipality" class="form-control">
                                                                    <option value="<?= $row['municipality'] ?>">
                                                                        <?= $row['municipality'] ?></option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="brgy">Barangay</label>
                                                                <!-- <input type="text" class="form-control form-control" name="brgy" value="<?= $row['brgy'] ?>" placeholder="Barangay"> -->
                                                                <select name="brgy" class="form-control">
                                                                    <option value="<?= $row['brgy'] ?>">
                                                                        <?= $row['brgy'] ?></option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="address">Address</label>
                                                                <input type="address" class="form-control form-control"
                                                                    name="Address" value="<?= $row['address'] ?>"
                                                                    placeholder="Address (Purok)">
                                                            </div>




                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-danger btn-sm" type="button"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-sm btn-success">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- View Member Modal -->
                                <div class="modal fade view" id="viewModal<?= $row['id'] ?>" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">VIEW MEMBER</h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="member_id" value="<?php echo $row["id"]; ?>">
                                                <div class="row col-12 mx-auto">
                                                    <div class="col-4">
                                                        <div class="col mb-3">
                                                            <img src="functions/<?php echo $row['image_path']; ?>"
                                                                width="100" class="img" alt="Member Image">
                                                        </div>
                                                        <p class="text-dark h5">Personal Details</p>
                                                        <div class="form-group">
                                                            <label for="firstname">Firstname</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" id="firstname"
                                                                value="<?= $row['firstname'] ?>" name="firstname"
                                                                placeholder="First Name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="middlename">Middle Name</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" name="middlename"
                                                                value="<?= $row['middlename'] ?>"
                                                                placeholder="Middle Name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="lastname">Lastname</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" id="lastname"
                                                                value="<?= $row['lastname'] ?>" name="lastname"
                                                                placeholder="Last Name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="extension">Extension</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" id="extension"
                                                                name="extension" aria-describedby="emailHelp"
                                                                value="<?= $row['extension'] ?>"
                                                                placeholder="Extension (ex. Jr.)">
                                                        </div>


                                                    </div>

                                                    <div class="col-4 mt-4">
                                                        <p class="text-dark h5">Basic Information</p>
                                                        <div class="form-group">
                                                            <label for="dob">Date of Birth</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" id="dob"
                                                                value="<?= $row['dob'] ?>" name="dob">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="age">Age</label>
                                                            <input type="number" readonly
                                                                class="form-control form-control" name="age"
                                                                value="<?= $row['age'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="pob">Place of Birth</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" id="pob"
                                                                value="<?= $row['pob'] ?>" name="pob"
                                                                placeholder="Place of Birth">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="civil-status">Civil Status</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" id="civil-status"
                                                                name="civil-status" aria-describedby="emailHelp"
                                                                value="<?= $row['civil_status'] ?>"
                                                                placeholder="Civil Status">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tin">TIN</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" id="tin" name="tin" autocomplete="off"
                                                                aria-describedby="emailHelp" value="<?= $row['tin'] ?>"
                                                                placeholder="TIN number">
                                                        </div>
                                                    </div>

                                                    <div class="col-4 mt-4">
                                                        <p class="text-dark h5 mb-6">Contact Information</p>
                                                        <div class="form-group">
                                                            <label for="mobile-number">Mobile Number</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" id="mobile-number"
                                                                value="<?= $row['mobile_number'] ?>"
                                                                name="mobile-number" placeholder="First Name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email Address</label>
                                                            <input type="email" readonly
                                                                class="form-control form-control" name="email"
                                                                value="<?= $row['email'] ?>"
                                                                placeholder="Email Address">
                                                        </div>


                                                        <p class="text-dark h5 mt-3">Address</p>

                                                        <div class="form-group">
                                                            <label for="brgy">Barangay</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" name="brgy"
                                                                value="<?= $row['brgy'] ?>" placeholder="Barangay">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="municipality">Municipality</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" name="municipality"
                                                                value="<?= $row['municipality'] ?>"
                                                                placeholder="Municipality">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="province">Province</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" name="province"
                                                                value="<?= $row['province'] ?>" placeholder="Province">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="region">Region</label>
                                                            <input type="text" readonly
                                                                class="form-control form-control" name="region"
                                                                value="<?= $row['region'] ?>" placeholder="region">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Member Modal-->
                                <div class="modal fade delete" id="deleteModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to
                                                    delete this member?</h5>

                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <p>Deleting a member also remove it's data from database. Are you sure
                                                    you want to continue?</p>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-danger btn-sm" type="button"
                                                    data-dismiss="modal">Cancel</button>
                                                <a class="btn btn-danger btn-sm"
                                                    href="./functions/delete_member.php?id=<?php echo $row["id"]; ?>">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- newModal -->

                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });

    function displaySuccessModal(message) {
        // Create a modal dynamically using jQuery and Bootstrap classes
        var modal = $('<div class="modal" tabindex="-1" role="dialog">');
        var modalDialog = $('<div class="modal-dialog" role="document">');
        var modalContent = $('<div class="modal-content">');
        var modalHeader = $('<div class="modal-header">');
        var closeButton = $(
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
            );
        modalHeader.append(closeButton);
        modalContent.append(modalHeader);
        modalContent.append('<div class="modal-body"><p>' + message + '</p></div>');

        // Append the modal content to the modal dialog
        modalDialog.append(modalContent);

        // Append the modal dialog to the modal
        modal.append(modalDialog);

        // Append the modal to the body
        $('body').append(modal);

        // Show the modal
        modal.modal('show');

        // Remove the modal from the DOM after it is closed
        modal.on('hidden.bs.modal', function () {
            modal.remove();
        });
    }

    // Check if successMessage is defined and not empty
    if (typeof successMessage !== "undefined" && successMessage.trim() !== "") {
        displaySuccessModal(successMessage);
    }
</script>
<?php include('layouts/footer.php'); ?>