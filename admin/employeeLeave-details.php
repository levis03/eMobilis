<?php
// Start the session
session_start();
// Disable error reporting for production
error_reporting(0);
// Include the database connection file
include('../includes/dbconn.php');

// Check if the user is logged in; if not, redirect to login page
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Update the 'IsRead' status of the leave request
    $isread = 1;
    $did = intval($_GET['leaveid']);
    date_default_timezone_set('Asia/Kolkata');
    $admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));

    // Prepare and execute SQL query to update 'IsRead' status
    $sql = "UPDATE tblleaves set IsRead=:isread where id=:did";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isread', $isread, PDO::PARAM_STR);
    $query->bindParam(':did', $did, PDO::PARAM_STR);
    $query->execute();

    // Check if the form has been submitted to update leave details
    if (isset($_POST['update'])) {
        $did = intval($_GET['leaveid']);
        $description = $_POST['description'];
        $status = $_POST['status'];
        date_default_timezone_set('Asia/Kolkata');
        $admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));

        // Prepare and execute SQL query to update leave details
        $sql = "UPDATE tblleaves set AdminRemark=:description, Status=:status, AdminRemarkDate=:admremarkdate where id=:did";
        $query = $dbh->prepare($sql);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':admremarkdate', $admremarkdate, PDO::PARAM_STR);
        $query->bindParam(':did', $did, PDO::PARAM_STR);
        $query->execute();
        $msg = "Leave updated Successfully";
    }
?>

    <!doctype html>
    <html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Panel - Employee Leave</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon and CSS includes -->
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
        <!-- Modernizr for feature detection -->
        <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>

    <body>
        <!-- Preloader -->
        <div id="preloader">
            <div class="loader"></div>
        </div>

        <!-- Page container -->
        <div class="page-container">
            <!-- Sidebar menu -->
            <div class="sidebar-menu">
                <div class="sidebar-header">
                    <div class="logo">
                        <a href="dashboard.php"><img src="../assets/images/icon/emobilis_logo.jpeg" alt="logo"></a>
                    </div>
                </div>
                <div class="main-menu">
                    <div class="menu-inner">
                        <?php
                        $page = "employee";
                        include '../includes/admin-sidebar.php';
                        ?>
                    </div>
                </div>
            </div>
            <!-- Main content area -->
            <div class="main-content">
                <!-- Header area -->
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
                                <?php include '../includes/admin-notification.php'; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Page title area -->
                <div class="page-title-area">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="breadcrumbs-area clearfix">
                                <h4 class="page-title pull-left">Leave Details</h4>
                                <ul class="breadcrumbs pull-left">
                                    <li><a href="dashboard.php">Home</a></li>
                                    <li><span>Leave Details</span></li>
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
                <!-- Main content inner -->
                <div class="main-content-inner">
                    <!-- Row area -->
                    <div class="row">
                        <!-- Striped table -->
                        <div class="col-lg-12 mt-5">
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
                                <div class="card-body">
                                    <div class="single-table">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover text-center">
                                                <tbody>
                                                    <?php
                                                    $lid = intval($_GET['leaveid']);
                                                    $sql = "SELECT tblleaves.id as lid, tblemployees.FirstName, tblemployees.LastName, tblemployees.EmpId, tblemployees.id, tblemployees.Gender, tblemployees.Phonenumber, tblemployees.EmailId, tblleaves.LeaveType, tblleaves.ToDate, tblleaves.FromDate, tblleaves.Description, tblleaves.PostingDate, tblleaves.Status, tblleaves.AdminRemark, tblleaves.AdminRemarkDate 
                                                FROM tblleaves 
                                                JOIN tblemployees ON tblleaves.empid=tblemployees.id 
                                                WHERE tblleaves.id=:lid";
                                                    $query = $dbh->prepare($sql);
                                                    $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt = 1;
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) {
                                                    ?>
                                                            <tr>
                                                                <td><b>Employee ID:</b></td>
                                                                <td colspan="1"><?php echo htmlentities($result->EmpId); ?></td>
                                                                <td><b>Employee Name:</b></td>
                                                                <td colspan="1"><a href="update-employee.php?empid=<?php echo htmlentities($result->id); ?>" target="_blank"><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?></a></td>
                                                                <td><b>Gender :</b></td>
                                                                <td colspan="1"><?php echo htmlentities($result->Gender); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Employee Email:</b></td>
                                                                <td colspan="1"><?php echo htmlentities($result->EmailId); ?></td>
                                                                <td><b>Phone No:</b></td>
                                                                <td colspan="1"><?php echo htmlentities($result->Phonenumber); ?></td>
                                                                <td><b>Leave Type:</b></td>
                                                                <td colspan="1"><?php echo htmlentities($result->LeaveType); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Leave From:</b></td>
                                                                <td colspan="1"><?php echo htmlentities($result->FromDate); ?></td>
                                                                <td><b>Leave To:</b></td>
                                                                <td colspan="1"><?php echo htmlentities($result->ToDate); ?></td>
                                                                <td><b>Posted Date:</b></td>
                                                                <td colspan="1"><?php echo htmlentities($result->PostingDate); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Description:</b></td>
                                                                <td colspan="5"><?php echo htmlentities($result->Description); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Admin Remark:</b></td>
                                                                <td colspan="5"><?php echo htmlentities($result->AdminRemark); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Admin Remark Date:</b></td>
                                                                <td colspan="5"><?php echo htmlentities($result->AdminRemarkDate); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Status:</b></td>
                                                                <td colspan="5"><?php echo htmlentities($result->Status); ?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Update Leave Form -->
                                        <form method="post" class="form-horizontal">
                                            <div class="form-group">
                                                <label for="description" class="col-sm-2 control-label">Admin Remark</label>
                                                <div class="col-sm-10">
                                                    <textarea name="description" id="description" class="form-control" placeholder="Admin Remark" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="status" class="col-sm-2 control-label">Leave Status</label>
                                                <div class="col-sm-10">
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="Approved">Approved</option>
                                                        <option value="Declined">Declined</option>
                                                        <option value="Pending">Pending</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" name="update" class="btn btn-primary">Update Leave</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer area -->
                <div class="footer-area">
                    <p>© 2024 Admin Panel</p>
                </div>
            </div>
        </div>
        <!-- JS Includes -->
        <script src="../assets/js/vendor/jquery-3.4.1.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/metisMenu.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/slicknav.min.js"></script>
        <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="https://www.amcharts.com/lib/3/serial.js"></script>
        <script src="https://www.amcharts.com/lib/3/export.min.js"></script>
        <script src="../assets/js/main.js"></script>
    </body>

    </html>


<?php } ?>