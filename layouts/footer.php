</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- accounts -->

<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Admin</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row col-xl-6 col-md-12 mb-2 align-items-start">
                    <div class="col-1">
                        <a class="btn btn-success btn" data-toggle="modal" title="Add new Administrator (Single Insertion)" data-target="#newModal2"><i class="fa-solid fa-plus"></i></a>
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

                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#viewModal<?= $row['id'] ?>"><i class="fa-solid fa-eye"></i></button>
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

<div class="modal fade add_member" id="newMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add member</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="user" method="post" action="./functions/add_member.php" enctype="multipart/form-data">


                    <div class="row py-4">
                        <div class="col-lg-6 mx-auto">

                            <!-- Upload image input-->
                            <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                <input id="upload" name="image" type="file" onchange="readURL(this);" class="form-control border-0">
                                <!-- <label id="upload-label" for="upload" class="font-weight-light text-muted">Choose file</label> -->
                                <div class="input-group-append">
                                    <label for="upload" class="btn btn-light m-0 rounded-pill px-4"> <i class="fa fa-cloud-upload mr-2 text-muted"></i><small class="text-uppercase font-weight-bold text-muted">Choose file</small></label>
                                </div>
                            </div>

                            <!-- Uploaded image area-->
                            <p class="font-italic text-dark text-center">The image uploaded will be rendered inside the box below.</p>
                            <div class="image-area mt-2">
                                <img id="imageResult" src="img/watermark.jpg" alt="" class="img-fluid rounded shadow-sm mx-auto d-block">
                            </div>

                        </div>
                    </div>

                    <script>
                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();

                                reader.onload = function(e) {
                                    $('#imageResult')
                                        .attr('src', e.target.result);
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                        }

                        $(function() {
                            $('#upload').on('change', function() {
                                readURL(input);
                            });
                        });
                        var input = document.getElementById('upload');
                        var infoArea = document.getElementById('upload-label');

                        input.addEventListener('change', showFileName);

                        function showFileName(event) {
                            var input = event.srcElement;
                            var fileName = input.files[0].name;
                            infoArea.textContent = 'File name: ' + fileName;
                        }
                    </script>

                    <div class="row col-12 mx-auto">
                        <div class="col-4">
                            <p class="text-success small h5">Name</p>
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input id="addFirstName" oninput="capitalizeInput('addFirstName')" type="text" class="form-control" name="firstname" placeholder="Juan" required>
                            </div>
                            <div class="form-group">
                                <label for="middlename">Middle Name</label>
                                <input id="addMiddleName" oninput="capitalizeInput('addMiddleName')" type="text" class="form-control" name="middlename" placeholder="Mendez" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input id="addLastName" oninput="capitalizeInput('addLastName')" type="text" class="form-control" name="lastname" placeholder="Dela Cruz" required>
                            </div>
                            <div class="form-group">
                                <label for="extension">Suffix (optional)</label>
                                <select class="form-control form-select form-select-sm" name="extension">
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
                            <p class="text-success small h5">Basic Information</p>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" name="age" required>
                            </div>
                            <div class="form-group">
                                <label for="pob">Place of Birth</label>

                                <input name="pob" cols="10" rows="4" class="form-control" placeholder="Place of Birth" required />
                            </div>
                            <div class="form-group">
                                <label for="civil-status">Civil Status</label>
                                <select class="form-control form-select form-select-sm" name="civil-status">
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Divorced">Divorced</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tin">TIN</label>
                                <input type="number" class="form-control" name="tin" autocomplete="off" aria-describedby="emailHelp" placeholder="TIN number" required>
                            </div>
                        </div>

                        <div class="col-4">
                            <p class="text-success small h5 mb-6">Contact Information</p>
                            <div class="form-group">
                                <label for="mobile-number">Mobile Number</label>
                                <input type="number" class="form-control" number" name="mobile-number" placeholder="Mobile" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                            </div>


                            <p class="text-success h5 mt-3">Address</p>
                            <div class="form-group">
                                <label for="province">Region</label>
                                <select name="region" class="form-control" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="province">Province</label>
                                <select name="province" class="form-control" required></select>
                            </div>
                            <div class="form-group">
                                <label for="municipality">Municipality</label>
                                <select class="form-control" required name="municipality"></select>
                            </div>
                            <div class="form-group">
                                <label for="brgy">Barangay</label>
                                <select class="form-control" required name="brgy"></select>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Address">
                            </div>
                        </div>
                    </div>

                    <script>
                        document.getElementById('image').addEventListener('change', function(e) {
                            const imagePreview = document.getElementById('imagePreview');
                            const file = e.target.files[0];
                            const reader = new FileReader();

                            reader.onload = function() {
                                imagePreview.innerHTML = `<img src="${reader.result}" width="100" alt="Image Preview">`;
                            };

                            if (file) {
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>

            </div>

            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-success">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="newModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Admin</h5>

                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="user" method="post" action="./functions/add_member.php" enctype="multipart/form-data">


                    <div class="row col-12 mx-auto">
                        <div class="col-12">
                            <p class="text-success small h5">Email Address</p>
                            <div class="form-group">
                                <label for="email_address">Firstname</label>
                                <input type="email" class="form-control" id="email" name="email_address" placeholder="jdl@gmail.com" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="jdl_cruz" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="extension">Suffix (optional)</label>
                                <select class="form-control form-select form-select-sm" name="extension">
                                    <option value="N/A">None</option>
                                    <option value="Sr.">Sr</option>
                                    <option value="Jr.">JR</option>
                                    <option value="I">I</option>
                                    <option value="I">II</option>
                                    <option value="I">III</option>
                                </select>
                            </div>

                        </div>


                    </div>
                    <script>
                        document.getElementById('image').addEventListener('change', function(e) {
                            const imagePreview = document.getElementById('imagePreview');
                            const file = e.target.files[0];
                            const reader = new FileReader();

                            reader.onload = function() {
                                imagePreview.innerHTML = `<img src="${reader.result}" width="100" alt="Image Preview">`;
                            };

                            if (file) {
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>

            </div>

            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-success">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to logout?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success btn-sm" href="./functions/logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>


<!-- modals -->
<div class="modal fade" id="viewModalAdmin<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View member</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="member_id" value="<?php echo $row["id"]; ?>">
                <div class="row col-12 mx-auto">
                    <div class="col-4">
                        <p class="text-success h5">Personal Details</p>
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input type="text" readonly class="form-control" id="firstname" value="<?= $row['firstname'] ?>" name="firstname" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="middlename">Middle Name</label>
                            <input type="text" readonly class="form-control" name="middlename" value="<?= $row['middlename'] ?>" placeholder="Middle Name">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" readonly class="form-control" id="lastname" value="<?= $row['lastname'] ?>" name="lastname" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <label for="extension">Extension</label>
                            <input type="text" readonly class="form-control" id="extension" name="extension" aria-describedby="emailHelp" value="<?= $row['extension'] ?>" placeholder="Extension (ex. Jr.)">
                        </div>


                    </div>

                    <div class="col-4 mt-4">
                        <p class="text-success h5">Basic Information</p>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="text" readonly class="form-control" id="dob" value="<?= $row['dob'] ?>" name="dob">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" readonly class="form-control" name="age" value="<?= $row['age'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="pob">Place of Birth</label>
                            <input type="text" readonly class="form-control" id="pob" value="<?= $row['pob'] ?>" name="pob" placeholder="Place of Birth">
                        </div>
                        <div class="form-group">
                            <label for="civil-status">Civil Status</label>
                            <input type="text" readonly class="form-control" id="civil-status" name="civil-status" aria-describedby="emailHelp" value="<?= $row['civil_status'] ?>" placeholder="Civil Status">
                        </div>

                        <div class="form-group">
                            <label for="tin">TIN</label>
                            <input type="text" readonly class="form-control" id="tin" name="tin" autocomplete="off" aria-describedby="emailHelp" value="<?= $row['tin'] ?>" placeholder="TIN number">
                        </div>
                    </div>

                    <div class="col-4 mt-4">
                        <p class="text-success h5 mb-6">Contact Information</p>
                        <div class="form-group">
                            <label for="mobile-number">Mobile Number</label>
                            <input type="text" readonly class="form-control" id="mobile-number" value="<?= $row['mobile_number'] ?>" name="mobile-number" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" readonly class="form-control" name="email" value="<?= $row['email'] ?>" placeholder="Email Address">
                        </div>


                        <p class="text-success h5 mt-3">Address</p>

                        <div class="form-group">
                            <label for="brgy">Barangay</label>
                            <input type="text" readonly class="form-control" name="brgy" value="<?= $row['brgy'] ?>" placeholder="Barangay">
                        </div>
                        <div class="form-group">
                            <label for="municipality">Municipality</label>
                            <input type="text" readonly class="form-control" name="municipality" value="<?= $row['municipality'] ?>" placeholder="Municipality">
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" readonly class="form-control" name="province" value="<?= $row['province'] ?>" placeholder="Province">
                        </div>
                        <div class="form-group">
                            <label for="region">Region</label>
                            <input type="text" readonly class="form-control" name="region" value="<?= $row['region'] ?>" placeholder="region">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of modals -->

<!-- update profile -->
<div class="modal fade" id="updateProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="./functions/update_profile.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>

                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>

                    <button class="btn btn-danger btn-sm" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success btn-sm" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="./vendor/jquery/jquery.min.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="./js/sb-admin-2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        var dob = $('.add_member input[name=dob]');
        var edit_dob = $('.edit.show input[name=dob]');

        var age = $('.add_member input[name=age]');
        var edit_age = $('.edit.show input[name=age]');

        dob.on('change', function() {
            calculateAge($(this), age);
        });

        edit_dob.on('change', function() {
            calculateAge($(this), edit_age);
        });


        function calculateAge(dobElement, ageElement) {
            // Get the birthdate input value
            var birthdateInput = dobElement.val();

            // Create a Date object from the input value
            var birthdate = new Date(birthdateInput);

            // Get the current date
            var currentDate = new Date();

            // Calculate the age
            var age = currentDate.getFullYear() - birthdate.getFullYear();

            // Check if birthday has occurred this year
            if (currentDate.getMonth() < birthdate.getMonth() || (currentDate.getMonth() === birthdate.getMonth() && currentDate.getDate() < birthdate.getDate())) {
                age--;
            }


            // Set the age field value
            ageElement.val(age);
        }
    });

    $(document).ready(function() {
        var jsonData;

        // Load JSON data from external file
        $.getJSON('functions/config/address.json', function(data) {
            jsonData = data;

            // Populate region dropdown
            populateRegionDropdown('.add_member', 'select[name=region]', jsonData, true);

            // Handle region change
            $('.add_member select[name="region"]').change(function() {
                var selectedRegion = $(this).val();
                var provinces = jsonData[selectedRegion].province_list;
                populateDropdown('.add_member', 'select[name=province]', Object.keys(provinces));
            });

            // Handle province change
            $('.add_member select[name="province"]').change(function() {
                var selectedRegion = $('.add_member select[name="region"]').val();
                var selectedProvince = $(this).val();
                var municipalitiesObject = jsonData[selectedRegion].province_list[selectedProvince].municipality_list;

                var municipalities = Object.values(municipalitiesObject).map(obj => Object.keys(obj)[0]);

                console.log(municipalities);

                populateDropdown('.add_member', 'select[name=municipality]', municipalities);
            });

            // Handle municipality change
            $('.add_member select[name="municipality"]').change(function() {
                var selectedRegion = $('.add_member select[name="region"]').val();
                var selectedProvince = $('.add_member select[name="province"]').val();
                var selectedMunicipality = $(this).val();

                // Find the municipality object in the array
                var municipalityObject = jsonData[selectedRegion].province_list[selectedProvince].municipality_list.find(obj => Object.keys(obj)[0] === selectedMunicipality);

                if (municipalityObject) {
                    var barangays = municipalityObject[selectedMunicipality].barangay_list;

                    // Populate barangay dropdown
                    populateDropdown('.add_member', 'select[name=brgy]', barangays);
                }
            });
        });





        $(document).on('click', '.updateMemberBtn', function() {


            var $modal = $(this).data('target');
            var $selected_region = $(this).data('region');

            $.getJSON('functions/config/address.json', function(data) {

                jsonData = data;

                populateRegionDropdown(false, $modal + ' select[name=region]', jsonData, true, $selected_region);

                // Handle region change
                $(document).on('change', $modal + ' select[name="region"]', function() {
                    var selectedRegion = $(this).val();
                    var provinces = jsonData[selectedRegion].province_list;
                    populateDropdown(false, $modal + ' select[name=province]', Object.keys(provinces));
                });

                // Handle province change
                $($modal + ' select[name="province"]').change(function() {
                    var selectedRegion = $($modal + ' select[name="region"]').val();
                    var selectedProvince = $(this).val();

                    var municipalitiesObject = jsonData[selectedRegion].province_list[selectedProvince].municipality_list;
                    var municipalities = Object.values(municipalitiesObject).map(obj => Object.keys(obj)[0]);

                    populateDropdown(false, $modal + ' select[name=municipality]', municipalities);
                });

                // Handle municipality change
                $($modal + ' select[name="municipality"]').change(function() {
                    var selectedRegion = $($modal + ' select[name="region"]').val();
                    var selectedProvince = $($modal + ' select[name="province"]').val();
                    var selectedMunicipality = $(this).val();

                    // $ the municipality object in the array
                    var municipalityObject = jsonData[selectedRegion].province_list[selectedProvince].municipality_list.find(obj => Object.keys(obj)[0] === selectedMunicipality);

                    if (municipalityObject) {
                        var barangays = municipalityObject[selectedMunicipality].barangay_list;

                        // Populate barangay dropdown
                        populateDropdown(false, $modal + ' select[name=brgy]', barangays);
                    }
                });
            })
        });



    });


    // Function to populate a dropdown
    function populateDropdown(parentElement = false, dropdownElement, values, empty = false) {
        var dropdown = $(parentElement ? parentElement + ' ' + dropdownElement : dropdownElement);

        if(!empty){
            dropdown.empty();
        }

        dropdown.append("<option value=''>Select</option>");

        $.each(values, function(index, value) {
            dropdown.append('<option value="' + value + '">' + value + '</option>');
        });
    }

    // Function to populate a dropdown
    function populateRegionDropdown(parentElement = false, dropdownElement, values, empty = false, selected_region = false) {
        var dropdown = $(parentElement ? parentElement + ' ' + dropdownElement : dropdownElement);

        if(!empty){
            dropdown.empty();
        }
        
        dropdown.append("<option value=''>Select</option>");

        $.each(values, function(regionCode, regionData) {

            if(selected != false){
                var selected = selected_region.toString() === regionCode ? 'selected':'';
                console.log( selected );
            }else {
                selected = false;
            }

            dropdown.append('<option '+ selected +' value="' + regionCode + '">' + regionData.region_name + '</option>');
        });
    }

    function capitalizeInput(id) {
        var inputElement = document.getElementById(id);
        var words = inputElement.value.split(' ');
        for (var i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].substring(1);
        }
        inputElement.value = words.join(' ');
    }


</script>
</body>

</html>