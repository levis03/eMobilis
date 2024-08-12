<?php
// Start the session
session_start();

// Disable error reporting
error_reporting(0);

// Include the database connection file
include('../includes/dbconn.php');

// Check if the session variable for login is empty
if (strlen($_SESSION['alogin']) == 0) {
    // Redirect to login page if not logged in
    header('location:index.php');
} else {
    // Check if the form has been submitted
    if (isset($_POST['add'])) {
        // Retrieve form input values
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];

        // Check if password and confirm password fields match
        if ($password !== $confirmpassword) {
            $error = "New Password and Confirm Password fields do not match!";
        } else {
            // Hash the password with bcrypt
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // SQL query to insert new admin details into the database
            $sql = "INSERT INTO admin(fullname,email,Password,UserName) VALUES(:fullname,:email,:password,:username)";
            $query = $dbh->prepare($sql);

            // Bind parameters to the SQL query
            $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $query->bindParam(':username', $username, PDO::PARAM_STR);

            // Execute the query
            $query->execute();

            // Get the ID of the last inserted record
            $lastInsertId = $dbh->lastInsertId();

            // Check if insertion was successful
            if ($lastInsertId) {
                $msg = "New admin has been added successfully";
            } else {
                $error = "ERROR";
            }
        }
    }
?>

    <!doctype html>
    <html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Panel - Employee Leave</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/css/themify-icons.css">
        <link rel="stylesheet" href="../assets/css/metisMenu.css">
        <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="../assets/css/slicknav.min.css">
        <!-- amchart css -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <!-- others css -->
        <link rel="stylesheet" href="../assets/css/typography.css">
        <link rel="stylesheet" href="../assets/css/default-css.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
        <!-- modernizr css -->
        <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>

        <!-- Custom form validation script -->
        <script type="text/javascript">
            function valid() {
                // Check if password and confirm password fields match
                if (document.addemp.password.value !== document.addemp.confirmpassword.value) {
                    alert("New Password and Confirm Password fields do not match!!");
                    document.addemp.confirmpassword.focus();
                    return false;
                }
                return true;
            }
        </script>

        <!-- Check availability of employee ID -->
        <script>
            function checkAvailabilityEmpid() {
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'empcode=' + $("#empcode").val(),
                    type: "POST",
                    success: function(data) {
                        $("#empid-availability").html(data);
                        $("#loaderIcon").hide();
                    },
                    error: function() {}
                });
            }
        </script>

        <!-- Check availability of email ID -->
        <script>
            function checkAvailabilityEmailid() {
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'emailid=' + $("#email").val(),
                    type: "POST",
                    success: function(data) {
                        $("#emailid-availability").html(data);
                        $("#loaderIcon").hide();
                    },
                    error: function() {}
                });
            }
        </script>
    </head>

    <body>
        <!-- Preloader area start -->
        <div id="preloader">
            <div class="loader"></div>
        </div>
        <!-- Preloader area end -->

        <div class="page-container">
            <!-- Sidebar menu area start -->
            <div class="sidebar-menu">
                <div class="sidebar-header">
                    <div class="logo">
                        <a href="dashboard.php"><img src="../assets/images/icon/emobilis_logo.jpeg" alt="logo"></a>
                    </div>
                </div>
                <div class="main-menu">
                    <div class="menu-inner">
                        <?php
                        $page = 'manage-admin';
                        include '../includes/admin-sidebar.php';
                        ?>
                    </div>
                </div>
            </div>
            <!-- Sidebar menu area end -->

            <!-- Main content area start -->
            <div class="main-content">
                <!-- Header area start -->
                <div class="header-area">
                    <div class="row align-items-center">
                        <!-- Nav and search button -->
                        <div class="col-md-6 col-sm-8 clearfix">
                            <div class="nav-btn pull-left">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>

                        <!-- Profile info & task notification -->
                        <div class="col-md-6 col-sm-4 clearfix">
                            <ul class="notification-area pull-right">
                                <li id="full-view"><i class="ti-fullscreen"></i></li>
                                <li id="full-view-exit"><i class="ti-zoom-out"></i></li>

                                <!-- Notification bell -->
                                <?php include '../includes/admin-notification.php' ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Header area end -->

                <!-- Page title area start -->
                <div class="page-title-area">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="breadcrumbs-area clearfix">
                                <h4 class="page-title pull-left">Add Admin Section</h4>
                                <ul class="breadcrumbs pull-left">
                                    <li><a href="manage-admin.php">Manage Admin</a></li>
                                    <li><span>Add</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-sm-6 clearfix">
                            <div class="user-profile pull-right">
                                <img class="avatar user-thumb" src="../assets/images/administrator.png" alt="avatar">
                                <h4 class="user-name dropdown-toggle" data-toggle="dropdown">ADMIN <i class="fa fa-angle-down"></i></h4>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="logout.php">Log Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page title area end -->

                <div class="main-content-inner">
                    <!-- Row area start -->
                    <div class="row">
                        <div class="col-lg-6 col-ml-12">
                            <div class="row">
                                <!-- Input form start -->
                                <div class="col-12 mt-5">
                                    <?php if ($error) { ?>
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <strong>Info: </strong><?php echo htmlentities($error); ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php } else if ($msg) { ?>
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <strong>Info: </strong><?php echo htmlentities($msg); ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php } ?>

                                    <div class="card">
                                        <form name="addemp" method="POST" onsubmit="return valid();">
                                            <div class="card-body">
                                                <p class="text-muted font-14 mb-4">Please fill up the form in order to add a new system administrator</p>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Full Name</label>
                                                    <input class="form-control" name="fullname" type="text" required id="example-text-input">
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-email-input" class="col-form-label">Email ID</label>
                                                    <input class="form-control" name="email" type="email" autocomplete="off" required id="example-email-input">
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Username</label>
                                                    <input class="form-control" name="username" type="text" autocomplete="off" required id="example-text-input">
                                                </div>

                                                <h4>Setting Passwords</h4>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Password</label>
                                                    <input class="form-control" name="password" type="password" autocomplete="off" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Confirmation Password</label>
                                                    <input class="form-control" name="confirmpassword" type="password" autocomplete="off" required>
                                                </div>

                                                <button class="btn btn-primary" name="add" id="update" type="submit">PROCEED</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Input Form Ending point -->
                    </div>
                    <!-- Row area end -->
                </div>

                <?php include '../includes/footer.php' ?>
                <!-- Footer area end -->
            </div>
            <!-- Main content area end -->
        </div>

        <!-- jQuery latest version -->
        <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
        <!-- Bootstrap 4 JS -->
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/metisMenu.min.js"></script>
        <script src="../assets/js/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/jquery.slicknav.min.js"></script>

        <!-- Chart.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <!-- Highcharts -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <!-- ZingChart -->
        <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
        <script>
            zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
        </script>
        <!-- Line chart activation -->
        <script src="assets/js/line-chart.js"></script>
        <!-- Pie chart -->
        <script src="assets/js/pie-chart.js"></script>

        <!-- Others plugins -->
        <script src="../assets/js/plugins.js"></script>
        <script src="../assets/js/scripts.js"></script>
    </body>

    </html>

<?php } ?>