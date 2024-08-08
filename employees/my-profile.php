<?php
// Start the session
session_start();

// Disable error reporting
error_reporting(0);

// Include database connection file
include('../includes/dbconn.php');

// Check if the user is not logged in
if (strlen($_SESSION['emplogin']) == 0) {
    // Redirect to login page if not logged in
    header('location:../index.php');
} else {
    // Get employee login session variable
    $eid = $_SESSION['emplogin'];

    // Check if the form has been submitted
    if (isset($_POST['update'])) {
        // Collect form data
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $department = $_POST['department'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $mobileno = $_POST['mobileno'];

        // Prepare SQL update statement
        $sql = "update tblemployees set FirstName=:fname, LastName=:lname, Gender=:gender, Dob=:dob, Department=:department, Address=:address, City=:city, Country=:country, Phonenumber=:mobileno where EmailId=:eid";
        $query = $dbh->prepare($sql);

        // Bind parameters to the SQL query
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':lname', $lname, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':department', $department, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);

        // Execute the SQL query
        $query->execute();

        // Set success message
        $msg = "Your record has been updated Successfully";
    }
?>

    <!doctype html>
    <html class="no-js" lang="en">

    <head>
        <!-- Meta tags and title -->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Employee Leave Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
        <!-- CSS stylesheets -->
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/css/themify-icons.css">
        <link rel="stylesheet" href="../assets/css/metisMenu.css">
        <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="../assets/css/slicknav.min.css">
        <!-- amchart css -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
        <!-- Other CSS -->
        <link rel="stylesheet" href="../assets/css/typography.css">
        <link rel="stylesheet" href="../assets/css/default-css.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
        <!-- Modernizr JS -->
        <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>

    <body>
        <!-- Preloader area -->
        <div id="preloader">
            <div class="loader"></div>
        </div>
        <!-- Page container area -->
        <div class="page-container">
            <!-- Sidebar menu area -->
            <div class="sidebar-menu">
                <div class="sidebar-header">
                    <div class="logo">
                        <a href="leave.php"><img src="../assets/images/icon/emobilis_logo.jpeg" alt="logo"></a>
                    </div>
                </div>
                <div class="main-menu">
                    <div class="menu-inner">
                        <nav>
                            <ul class="metismenu" id="menu">
                                <li class="#">
                                    <a href="leave.php" aria-expanded="true"><i class="ti-user"></i><span>Apply Leave</span></a>
                                </li>
                                <li class="#">
                                    <a href="leave-history.php" aria-expanded="true"><i class="ti-agenda"></i><span>View My Leave History</span></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Main content area -->
            <div class="main-content">
                <!-- Header area -->
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
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Page title area -->
                <div class="page-title-area">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="breadcrumbs-area clearfix">
                                <h4 class="page-title pull-left">My Profile</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 clearfix">
                            <!-- Include employee profile section -->
                            <?php include '../includes/employee-profile-section.php' ?>
                        </div>
                    </div>
                </div>
                <!-- Main content inner -->
                <div class="main-content-inner">
                    <div class="row">
                        <div class="col-lg-6 col-ml-12">
                            <div class="row">
                                <!-- Textual inputs start -->
                                <div class="col-12 mt-5">
                                    <?php
                                    // Display error or success message
                                    if ($error) { ?>
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
                                    <!-- Profile update form -->
                                    <div class="card">
                                        <form name="addemp" method="POST">
                                            <div class="card-body">
                                                <h4 class="header-title">Update My Profile</h4>
                                                <p class="text-muted font-14 mb-4">Please make changes on the form below in order to update your profile</p>

                                                <?php
                                                // Fetch employee details
                                                $sql = "SELECT * from tblemployees where EmailId=:eid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {
                                                ?>

                                                        <!-- Form fields for employee details -->
                                                        <div class="form-group">
                                                            <label for="example-text-input" class="col-form-label">First Name</label>
                                                            <input class="form-control" name="firstName" value="<?php echo htmlentities($result->FirstName); ?>" type="text" required id="example-text-input">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-text-input" class="col-form-label">Last Name</label>
                                                            <input class="form-control" name="lastName" value="<?php echo htmlentities($result->LastName); ?>" type="text" required id="example-text-input">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-text-input" class="col-form-label">Gender</label>
                                                            <input class="form-control" name="gender" value="<?php echo htmlentities($result->Gender); ?>" type="text" required id="example-text-input">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-text-input" class="col-form-label">Date of Birth</label>
                                                            <input class="form-control" name="dob" value="<?php echo htmlentities($result->Dob); ?>" type="date" required id="example-text-input">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-text-input" class="col-form-label">Department</label>
                                                            <input class="form-control" name="department" value="<?php echo htmlentities($result->Department); ?>" type="text" required id="example-text-input">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-text-input" class="col-form-label">Address</label>
                                                            <input class="form-control" name="address" value="<?php echo htmlentities($result->Address); ?>" type="text" required id="example-text-input">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-text-input" class="col-form-label">City</label>
                                                            <input class="form-control" name="city" value="<?php echo htmlentities($result->City); ?>" type="text" required id="example-text-input">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-text-input" class="col-form-label">Country</label>
                                                            <input class="form-control" name="country" value="<?php echo htmlentities($result->Country); ?>" type="text" required id="example-text-input">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="example-text-input" class="col-form-label">Mobile No</label>
                                                            <input class="form-control" name="mobileno" value="<?php echo htmlentities($result->Phonenumber); ?>" type="text" required id="example-text-input">
                                                        </div>

                                                        <div class="form-group">
                                                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                                                        </div>

                                                <?php }
                                                } ?>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Textual inputs end -->
                    </div>
                </div>
                <!-- Footer area -->
                <div class="footer-area">
                    <p>© 2024. All Rights Reserved. Emobilis</p>
                </div>
            </div>
        </div>
        <!-- JS scripts -->
        <script src="../assets/js/vendor/jquery-3.5.1.min.js"></script>
        <script src="../assets/js/vendor/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/vendor/jquery.dataTables.min.js"></script>
        <script src="../assets/js/vendor/dataTables.bootstrap4.min.js"></script>
        <script src="../assets/js/vendor/dataTables.responsive.min.js"></script>
        <script src="../assets/js/vendor/responsive.bootstrap4.min.js"></script>
        <script src="../assets/js/main.js"></script>
    </body>

    </html>


<?php } ?>