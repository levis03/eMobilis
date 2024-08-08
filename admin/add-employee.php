<?php
// Start the session
session_start();

// Disable error reporting
error_reporting(0);

// Include the database connection file
include('../includes/dbconn.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    // Redirect to login page if not logged in
    header('location:index.php');
} else {
    // Check if the form is submitted
    if (isset($_POST['add'])) {
        // Collect form data
        $empid = $_POST['empcode'];
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $department = $_POST['department'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $mobileno = $_POST['mobileno'];
        $status = 1;

        // Prepare SQL query for inserting data
        $sql = "INSERT INTO tblemployees(EmpId,FirstName,LastName,EmailId,Password,Gender,Dob,Department,Address,City,Country,Phonenumber,Status) VALUES(:empid,:fname,:lname,:email,:password,:gender,:dob,:department,:address,:city,:country,:mobileno,:status)";
        $query = $dbh->prepare($sql);

        // Bind parameters to the SQL query
        $query->bindParam(':empid', $empid, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':department', $department, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);

        // Execute the SQL query
        $query->execute();

        // Get the last inserted ID
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            // Success message
            $msg = "Record has been added Successfully";
        } else {
            // Error message
            $error = "ERROR";
        }
    }
?>

    <!doctype html>
    <html class="no-js" lang="en">

    <head>
        <!-- Character encoding and compatibility -->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Panel - Employee Leave</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">

        <!-- CSS files -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/css/themify-icons.css">
        <link rel="stylesheet" href="../assets/css/metisMenu.css">
        <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="../assets/css/slicknav.min.css">
        <!-- amchart css -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <!-- other css -->
        <link rel="stylesheet" href="../assets/css/typography.css">
        <link rel="stylesheet" href="../assets/css/default-css.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">

        <!-- Modernizr -->
        <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>

        <!-- Custom form script -->
        <script type="text/javascript">
            function valid() {
                // Validate password and confirm password fields
                if (document.addemp.password.value != document.addemp.confirmpassword.value) {
                    alert("New Password and Confirm Password Field do not match!!");
                    document.addemp.confirmpassword.focus();
                    return false;
                }
                return true;
            }
        </script>

        <!-- AJAX script to check employee ID availability -->
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

        <!-- AJAX script to check email availability -->
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
                        $page = 'employee';
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
                        <!-- Navigation and search button -->
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
                                <h4 class="page-title pull-left">Add Employee Section</h4>
                                <ul class="breadcrumbs pull-left">
                                    <li><a href="employees.php">Employee</a></li>
                                    <li><span>Add</span></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-sm-6 clearfix">
                            <div class="user-profile pull-right">
                                <img class="avatar user-thumb" src="../assets/images/admin.png" alt="avatar">
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
                                            <strong>Success: </strong><?php echo htmlentities($msg); ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php } ?>
                                    <!-- Add employee form -->
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title">Add Employee</h4>
                                            <form name="addemp" method="POST" onsubmit="return valid();">
                                                <div class="form-group">
                                                    <label for="empcode">Employee Code</label>
                                                    <input type="text" class="form-control" id="empcode" name="empcode" onBlur="checkAvailabilityEmpid()" required>
                                                    <span id="empid-availability" style="font-size:12px;"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="firstName">First Name</label>
                                                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="lastName">Last Name</label>
                                                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email Address</label>
                                                    <input type="email" class="form-control" id="email" name="email" onBlur="checkAvailabilityEmailid()" required>
                                                    <span id="emailid-availability" style="font-size:12px;"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control" id="password" name="password" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirmpassword">Confirm Password</label>
                                                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select class="form-control" id="gender" name="gender" required>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dob">Date of Birth</label>
                                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="department">Department</label>
                                                    <input type="text" class="form-control" id="department" name="department" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <input type="text" class="form-control" id="address" name="address" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="city">City</label>
                                                    <input type="text" class="form-control" id="city" name="city" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="country">Country</label>
                                                    <input type="text" class="form-control" id="country" name="country" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mobileno">Mobile Number</label>
                                                    <input type="text" class="form-control" id="mobileno" name="mobileno" required>
                                                </div>
                                                <button type="submit" name="add" class="btn btn-primary">Add Employee</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Input form end -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Row area end -->
                </div>
            </div>
            <!-- Main content area end -->
        </div>

        <!-- Footer area start -->
        <?php include '../includes/footer.php' ?>
        <!-- Footer area end -->

        <!-- JS files -->
        <script src="../assets/js/vendor/jquery-3.5.1.min.js"></script>
        <script src="../assets/js/vendor/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/vendor/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="../assets/js/vendor/jquery.dataTables.min.js"></script>
        <script src="../assets/js/vendor/dataTables.bootstrap4.min.js"></script>
        <script src="../assets/js/vendor/modernizr-3.6.0.min.js"></script>
        <script src="../assets/js/main.js"></script>
    </body>

    </html>


<?php } ?>