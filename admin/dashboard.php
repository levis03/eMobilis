<?php
// Start session and suppress error reporting
session_start();
error_reporting(0);

// Include database connection file
include('../includes/dbconn.php');

// Redirect to login page if session variable 'alogin' is not set
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
?>

    <!doctype html>
    <html class="no-js" lang="en">

    <head>
        <!-- Meta tags and title -->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Panel - Employee Leave</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicon and CSS files -->
        <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/css/themify-icons.css">
        <link rel="stylesheet" href="../assets/css/metisMenu.css">
        <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="../assets/css/slicknav.min.css">
        <!-- AmCharts CSS -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <!-- Additional CSS files -->
        <link rel="stylesheet" href="../assets/css/typography.css">
        <link rel="stylesheet" href="../assets/css/default-css.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">

        <!-- Modernizr JS for feature detection -->
        <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>

    <body>
        <!-- Preloader start -->
        <div id="preloader">
            <div class="loader"></div>
        </div>
        <!-- Preloader end -->

        <div class="page-container">
            <!-- Sidebar menu area start -->
            <div class="sidebar-menu">
                <div class="sidebar-header">
                    <div class="logo">
                        <!-- Link to dashboard with logo -->
                        <a href="dashboard.php"><img src="../assets/images/icon/emobilis_logo.jpeg" alt="logo"></a>
                    </div>
                </div>
                <div class="main-menu">
                    <div class="menu-inner">
                        <?php
                        // Set page variable for sidebar highlighting and include sidebar menu
                        $page = 'dashboard';
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
                        <!-- Profile info and task notifications -->
                        <div class="col-md-6 col-sm-4 clearfix">
                            <ul class="notification-area pull-right">
                                <li id="full-view"><i class="ti-fullscreen"></i></li>
                                <li id="full-view-exit"><i class="ti-zoom-out"></i></li>

                                <!-- Include notifications -->
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
                                <h4 class="page-title pull-left">Dashboard</h4>
                                <ul class="breadcrumbs pull-left">
                                    <li><a href="dashboard.php">Home</a></li>
                                    <li><span>Admin's Dashboard</span></li>
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
                    <!-- Sales report area start -->
                    <div class="sales-report-area mt-5 mb-5">
                        <div class="row">
                            <!-- Leave Types Report -->
                            <div class="col-md-4">
                                <div class="single-report mb-xs-30">
                                    <div class="s-report-inner pr--20 pt--30 mb-3">
                                        <div class="icon"><i class="fa fa-briefcase"></i></div>
                                        <div class="s-report-title d-flex justify-content-between">
                                            <h4 class="header-title mb-0">Available Leave Types</h4>
                                        </div>
                                        <div class="d-flex justify-content-between pb-2">
                                            <h1><?php include 'counters/leavetype-counter.php' ?></h1>
                                            <span>Leave Types</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Registered Employees Report -->
                            <div class="col-md-4">
                                <div class="single-report mb-xs-30">
                                    <div class="s-report-inner pr--20 pt--30 mb-3">
                                        <div class="icon"><i class="fa fa-users"></i></div>
                                        <div class="s-report-title d-flex justify-content-between">
                                            <h4 class="header-title mb-0">Registered Employees</h4>
                                        </div>
                                        <div class="d-flex justify-content-between pb-2">
                                            <h1><?php include 'counters/emp-counter.php' ?></h1>
                                            <span>Active Employees</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Available Departments Report -->
                            <div class="col-md-4">
                                <div class="single-report">
                                    <div class="s-report-inner pr--20 pt--30 mb-3">
                                        <div class="icon"><i class="fa fa-th-large"></i></div>
                                        <div class="s-report-title d-flex justify-content-between">
                                            <h4 class="header-title mb-0">Available Departments</h4>
                                        </div>
                                        <div class="d-flex justify-content-between pb-2">
                                            <h1><?php include 'counters/dept-counter.php' ?></h1>
                                            <span>Employee Departments</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <!-- Pending Applications Report -->
                            <div class="col-md-4">
                                <div class="single-report mb-xs-30">
                                    <div class="s-report-inner pr--20 pt--30 mb-3">
                                        <div class="icon"><i class="fa fa-spinner"></i></div>
                                        <div class="s-report-title d-flex justify-content-between">
                                            <h4 class="header-title mb-0">Pending Application</h4>
                                        </div>
                                        <div class="d-flex justify-content-between pb-2">
                                            <h1><?php include 'counters/pendingapp-counter.php' ?></h1>
                                            <span>Pending</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Declined Applications Report -->
                            <div class="col-md-4">
                                <div class="single-report mb-xs-30">
                                    <div class="s-report-inner pr--20 pt--30 mb-3">
                                        <div class="icon"><i class="fa fa-times"></i></div>
                                        <div class="s-report-title d-flex justify-content-between">
                                            <h4 class="header-title mb-0">Declined Application</h4>
                                        </div>
                                        <div class="d-flex justify-content-between pb-2">
                                            <h1><?php include 'counters/declineapp-counter.php' ?></h1>
                                            <span>Declined</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Approved Applications Report -->
                            <div class="col-md-4">
                                <div class="single-report">
                                    <div class="s-report-inner pr--20 pt--30 mb-3">
                                        <div class="icon"><i class="fa fa-check-square-o"></i></div>
                                        <div class="s-report-title d-flex justify-content-between">
                                            <h4 class="header-title mb-0">Approved Application</h4>
                                        </div>
                                        <div class="d-flex justify-content-between pb-2">
                                            <h1><?php include 'counters/approveapp-counter.php' ?></h1>
                                            <span>Approved</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sales report area end -->

                    <!-- Footer area start -->
                    <footer>
                        <div class="footer-area">
                            <p>&copy; <?php echo date('Y'); ?> eMobilis. All rights reserved.</p>
                        </div>
                    </footer>
                    <!-- Footer area end -->
                </div>
            </div>
            <!-- Main content area end -->
        </div>

        <!-- JS files -->
        <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/metisMenu.min.js"></script>
        <script src="../assets/js/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/jquery.slicknav.min.js"></script>
        <script src="../assets/js/modernizr-2.8.3.min.js"></script>
        <script src="../assets/js/amcharts.js"></script>
        <script src="../assets/js/serial.js"></script>
        <script src="../assets/js/export.min.js"></script>
        <script src="../assets/js/charts.js"></script>
        <script src="../assets/js/main.js"></script>
    </body>

    </html>

<?php
}
?>