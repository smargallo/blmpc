<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="../img/logo.png">

    <title>BLMPC</title>
    <link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- datatable -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Custom styles for this template-->
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- datatables -->
    <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="./css/custom.css">

    <head>



    </head>
    <style>
        #active-btn {
            background: green;
        }

        #inactive-btn {
            background: orangered;
        }

        #active-btn,
        #inactive-btn {
            color: #fff;
            border-radius: 30px;
        }
    </style>

    <?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("Location: index.php");
        exit;
    }
    ?>

    <style>
        #cont {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #card {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 10px 5px 30px gray;
        }

        input {
            border: 2px solid green;
            font-size: 20px;
        }

        .left {
            width: 60%;
            height: 100%;
            float: left;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-holder {
            background-color: #fff;
            border-radius: 100%;
        }

        .right {
            width: 40%;
            float: right;
            padding: 8%;
        }
    </style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
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
        <div id="cont" style="height: 100vh;">

            <div class="left bg-success">

                <div class="image-holder">
                    <img src="img/logo.png" alt="">
                </div>


            </div>
            <div class="right">
                <div id="card">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <img src="img/logo_2.png" width="80%" alt="">
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

                                <script>
                                    $(document).ready(function() {
                                        <?php if (isset($_SESSION['success'])) { ?>
                                            $('#registrationModal').modal('show');
                                        <?php } ?>
                                    });
                                </script>

                                <form class="user" action="./functions/register.php" method="POST">
                                    <h5 class="mt-1 mb-1 text-center">New Admin</h5>
                                    <p class="mb-1 mt-2 text-success">Note: <span class="small text-dark">This admin account creation only allows one account, please do remember your credentials!</span></p>
                                    <div class="form-group">

                                        <p class="errror_mss small text-danger text-center"><?php
                                                                                            if (isset($_SESSION['error_msg']) && !empty($_SESSION['error_msg'])) {
                                                                                                $successMessage = $_SESSION['error_msg'];
                                                                                                unset($_SESSION['error_msg']);
                                                                                                echo $successMessage;
                                                                                            }
                                                                                            ?></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" autocomplete="FALSE" class="form-control form-control-user" name="email" placeholder="Email Address">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="username" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" placeholder="Password" name="password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" placeholder="Confirm Password" name="confirm_password">
                                    </div>

                                    <div class="form-group">
                                        <!-- <div class="g-recaptcha" data-sitekey="6LcAEQIjAAAAAEoRxOki-nzj4FePO4lv-R5IlRV1"></div> -->
                                        <div class="g-recaptcha" data-sitekey="6LdDeiwpAAAAAM0rCW6Wk3UbcLBsfiD8ZU7STC1V"></div>
                                        <div id="captcha-error" class="text-danger"></div>
                                    </div>

                                    <input class="btn btn-success btn-user btn-block" type="submit" value="Login" />



                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="registrationModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registration Successful</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Email: <?php echo isset($_SESSION['registered_email']) ? $_SESSION['registered_email'] : ''; ?></p>
                        <p>Username: <?php echo isset($_SESSION['registered_username']) ? $_SESSION['registered_username'] : ''; ?></p>
                        <p>Password: <?php echo isset($_SESSION['registered_password']) ? $_SESSION['registered_password'] : ''; ?></p>
                        <p>Type: <?php echo isset($_SESSION['registered_type']) ? $_SESSION['registered_type'] : ''; ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://www.google.com/recaptcha/api.js" async defer></script>