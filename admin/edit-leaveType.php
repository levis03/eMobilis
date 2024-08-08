<?php
// Start the session to manage user authentication
session_start();
// Disable error reporting
error_reporting(0);
// Include the database connection file
include('../includes/dbconn.php');

// Check if the user is logged in; if not, redirect to the login page
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Check if the update form has been submitted
    if (isset($_POST['update'])) {
        // Retrieve and sanitize the leave ID and form data
        $lid = intval($_GET['lid']);
        $leavetype = $_POST['leavetype'];
        $description = $_POST['description'];

        // Prepare SQL query to update leave type details
        $sql = "UPDATE tblleavetype SET LeaveType = :leavetype, Description = :description WHERE id = :lid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':lid', $lid, PDO::PARAM_STR);
        $query->execute();

        // Set a success message
        $msg = "Leave type updated successfully";
    }
?>

    <!doctype html>
    <html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Panel - Employee Leave</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon icon -->
        <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
        <!-- Include CSS files -->
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
        <!-- Other CSS files -->
        <link rel="stylesheet" href="../assets/css/typography.css">
        <link rel="stylesheet" href="../assets/css/default-css.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
        <!-- Modernizr JS -->
        <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
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
                        <!-- Sidebar logo -->
                        <a href="dashboard.php"><img src="../assets/images/icon/emobilis_logo.jpeg" alt="logo"></a>
                    </div>
                </div>
                <div class="main-menu">
                    <div class="menu-inner">
                        <!-- Include sidebar menu -->
                        <?php
                        $page = 'leave';
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
                        <!-- Navigation button -->
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
                                <h4 class="page-title pull-left">Leave Section</h4>
                                <ul class="breadcrumbs pull-left">
                                    <li><a href="leave-section.php">Leave</a></li>
                                    <li><span>Edit</span></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Profile info -->
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
                        <!-- Form to update leave type -->
                        <div class="col-12 mt-5">
                            <div class="card">
                                <!-- Display error or success messages -->
                                <?php if ($error) { ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>Info: </strong><?php echo htmlentities($error); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php } elseif ($msg) { ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <strong>Info: </strong><?php echo htmlentities($msg); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php } ?>

                                <!-- Leave type update form -->
                                <form method="POST">
                                    <div class="card-body">
                                        <p class="text-muted font-14 mb-4">Please make changes on the form below in order to update leave type</p>

                                        <?php
                                        // Retrieve the leave type details to pre-fill the form
                                        $lid = intval($_GET['lid']);
                                        $sql = "SELECT * FROM tblleavetype WHERE id = :lid";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                        ?>
                                                <div class="form-group">
                                                    <label for="leavetype" class="col-form-label">Leave Type</label>
                                                    <input class="form-control" name="leavetype" type="text" required id="leavetype" value="<?php echo htmlentities($result->LeaveType); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="description" class="col-form-label">Short Description</label>
                                                    <input class="form-control" name="description" type="text" autocomplete="off" required id="description" value="<?php echo htmlentities($result->Description); ?>">
                                                </div>

                                        <?php }
                                        } ?>
                                        <!-- Submit button -->
                                        <button class="btn btn-primary" name="update" id="update" type="submit">MAKE CHANGES</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Row area end -->
                </div>
                <!-- Footer include -->
                <?php include '../includes/footer.php' ?>
                <!-- Footer area end -->
            </div>
            <!-- Main content area end -->
        </div>
        <!-- Include JavaScript files -->
        <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/metisMenu.min.js"></script>
        <script src="../assets/js/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/jquery.slicknav.min.js"></script>
        <!-- Chart JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <!-- Highcharts JS -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <!-- ZingChart JS -->
        <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
        <script>
            zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
        </script>
        <!-- Line chart activation -->
        <script src="assets/js/line-chart.js"></script>
        <!-- Pie chart activation -->
        <script src="assets/js/pie-chart.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
        <!-- Other plugins -->
        <script src="../assets/js/plugins.js"></script>
        <script src="../assets/js/scripts.js"></script>
    </body>

    </html>

<?php } ?>