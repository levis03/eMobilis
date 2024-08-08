<?php
// Start the session
session_start();
// Turn off error reporting
error_reporting(0);
// Include the database connection file
include('../includes/dbconn.php');

// Check if the user is logged in
if (strlen($_SESSION['emplogin']) == 0) {
    // Redirect to the login page if not logged in
    header('location:../index.php');
} else {
    // Check if the form is submitted
    if (isset($_POST['change'])) {
        // Get form data and hash passwords
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $username = $_SESSION['emplogin'];

        // Query to check if the current password matches
        $sql = "SELECT Password FROM tblemployees WHERE EmailId = :username AND Password = :password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            // Update the password if the current password is correct
            $con = "UPDATE tblemployees SET Password = :newpassword WHERE EmailId = :username";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "Your Password Has Been Updated.";
        } else {
            // Error message if the current password is wrong
            $error = "Sorry, your current password is wrong!";
        }
    }
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Employee Leave Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include CSS files -->
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- Include modernizr for feature detection -->
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
                            <li>
                                <a href="leave.php" aria-expanded="true"><i class="ti-user"></i><span>Apply Leave</span></a>
                            </li>
                            <li>
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
                            <h4 class="page-title pull-left">Change Current Password</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><span>Password Fields</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <!-- Include employee profile section -->
                        <?php include '../includes/employee-profile-section.php' ?>
                    </div>
                </div>
            </div>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row">
                            <!-- Password change form -->
                            <div class="col-12 mt-5">
                                <!-- Display error or success message -->
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
                                    <form name="chngpwd" method="POST">
                                        <div class="card-body">
                                            <h4 class="header-title">Change Password</h4>
                                            <p class="text-muted font-14 mb-4">Please fill up the form to change your current password.</p>

                                            <div class="form-group">
                                                <label for="password" class="col-form-label">Existing Password</label>
                                                <input class="form-control" id="password" type="password" autocomplete="off" name="password" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="newpassword" class="col-form-label">New Password</label>
                                                <input class="form-control" type="password" name="newpassword" id="newpassword" autocomplete="off" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="confirmpassword" class="col-form-label">Confirm Password</label>
                                                <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" autocomplete="off" required>
                                            </div>

                                            <button class="btn btn-primary" name="change" type="submit" onclick="return valid();">CHANGE PASSWORD</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer area -->
        <?php include '../includes/footer.php' ?>
    </div>

    <!-- Offset area -->
    <div class="offset-area">
        <div class="offset-close"><i class="ti-close"></i></div>
    </div>

    <!-- JavaScript files -->
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>