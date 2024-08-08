<?php
// Start the session to manage user authentication
session_start();
// Disable error reporting
error_reporting(0);
// Include the database connection file
include('../includes/dbconn.php');

// Check if user is logged in; if not, redirect to the login page
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Check if a delete request is made
    if (isset($_GET['del'])) {
        $id = $_GET['del'];
        // Prepare SQL query to delete a department based on the ID
        $sql = "DELETE FROM tbldepartments WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        // Set a success message
        $msg = "The selected department has been deleted";
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
                        $page = 'department';
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
                                <h4 class="page-title pull-left">Department Section</h4>
                                <ul class="breadcrumbs pull-left">
                                    <li><a href="dashboard.php">Home</a></li>
                                    <li><span>Department Management</span></li>
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
                        <!-- Dark table start -->
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

                                <div class="card-body">
                                    <!-- Table to display departments -->
                                    <div class="data-tables datatable-dark">
                                        <!-- Link to add a new department -->
                                        <center><a href="add-department.php" class="btn btn-sm btn-info">Add New Department</a></center>
                                        <table id="dataTable3" class="table table-hover table-striped text-center">
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Department</th>
                                                    <th>Shortform</th>
                                                    <th>Code</th>
                                                    <th>Created Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Query to fetch all departments
                                                $sql = "SELECT * FROM tbldepartments";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {
                                                ?>
                                                        <tr>
                                                            <td> <?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($result->DepartmentName); ?></td>
                                                            <td><?php echo htmlentities($result->DepartmentShortName); ?></td>
                                                            <td><?php echo htmlentities($result->DepartmentCode); ?></td>
                                                            <td><?php echo htmlentities($result->CreationDate); ?></td>
                                                            <td>
                                                                <!-- Edit and Delete actions -->
                                                                <a href="edit-department.php?deptid=<?php echo htmlentities($result->id); ?>">
                                                                    <i class="fa fa-edit" style="color:green"></i>
                                                                </a>
                                                                <a href="department.php?del=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Do you want to delete');">
                                                                    <i class="fa fa-trash" style="color:red"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $cnt++;
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dark table end -->
                    </div>
                    <!-- Row area end -->
                </div>
                <!-- Footer -->
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
        <!-- Start chart js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <!-- Start highcharts js -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <!-- Start zingchart js -->
        <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
        <script>
            zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
        </script>
        <!-- All line chart activation -->
        <script src="assets/js/line-chart.js"></script>
        <!-- All pie chart -->
        <script src="assets/js/pie-chart.js"></script>
        <!-- Start datatable js -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
        <!-- Others plugins -->
        <script src="../assets/js/plugins.js"></script>
        <script src="../assets/js/scripts.js"></script>
    </body>

    </html>

<?php } ?>