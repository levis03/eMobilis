<?php
// Start the session
session_start();
// Turn off error reporting
error_reporting(0);
// Include the database connection file
include('../includes/dbconn.php');

// Check if the user is logged in
if (strlen($_SESSION['emplogin']) == 0) {
    // Redirect to login page if not logged in
    header('location:../index.php');
} else {
    // Check if the form is submitted
    if (isset($_POST['apply'])) {
        // Retrieve form data from the form fields(applying for leave form)
        $empid = $_SESSION['eid'];
        $leavetype = $_POST['leavetype'];
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];
        $description = $_POST['description'];
        $status = 0; //Initialized to 0 (pending) since the leave request hasn't been approved yet
        $isread = 0; //also pending since admin hajasoma

        // Validate dates
        if ($fromdate > $todate) {
            $error = "Please enter correct details: End Date should be after the Starting Date to be valid!";
        }

        // Insert leave application into the database
        $sql = "INSERT INTO tblleaves(LeaveType, ToDate, FromDate, Description, Status, IsRead, empid) 
                    VALUES(:leavetype, :fromdate, :todate, :description, :status, :isread, :empid)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':leavetype', $leavetype, PDO::PARAM_STR);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':isread', $isread, PDO::PARAM_INT);
        $query->bindParam(':empid', $empid, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        // Check if the insertion was successful
        if ($lastInsertId) {
            $msg = "Your leave application has been applied, Thank You.";
        } else {
            $error = "Sorry, could not process this time. Please try again later.";
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
        <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/css/themify-icons.css">
        <link rel="stylesheet" href="../assets/css/metisMenu.css">
        <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="../assets/css/slicknav.min.css">
        <!-- amchart css -->
        <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
        <!-- Additional CSS -->
        <link rel="stylesheet" href="../assets/css/typography.css">
        <link rel="stylesheet" href="../assets/css/default-css.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
        <!-- Modernizr for feature detection -->
        <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>

    <body>
        <!-- Preloader area start -->
        <div id="preloader">
            <div class="loader"></div>
        </div>
        <!-- Preloader area end -->
        <!-- Page container area start -->
        <div class="page-container">
            <!-- Sidebar menu area start -->
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
                                <li class="active">
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
                                <h4 class="page-title pull-left">Apply For Leave Days</h4>
                                <ul class="breadcrumbs pull-left">
                                    <li><span>Leave Form</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 clearfix">
                            <!-- Include employee profile section -->
                            <?php include '../includes/employee-profile-section.php' ?>
                        </div>
                    </div>
                </div>
                <!-- Page title area end -->
                <div class="main-content-inner">
                    <div class="row">
                        <div class="col-lg-6 col-ml-12">
                            <div class="row">
                                <!-- Textual inputs start -->
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
                                        <form name="addemp" method="POST">
                                            <div class="card-body">
                                                <h4 class="header-title text-center">Employee Leave Form</h4>
                                                <p class="text-muted font-14 mb-4">
                                                    The annual leave entitlement is in accordance with Kenya labour law. As an Employee of eMobilis you are entitled to twenty-one (21) working days of leave plus any public holidays in compliance with Kenya Labour Laws.
                                                    <br><br>
                                                    According to Section 29 of Employment Act, 2007, female employees shall be entitled to 3 Calendar months maternity leave on full pay in addition to any period of annual leave.
                                                    <br><br>
                                                    Male employees shall be entitled 2 Calendar weeks paternity leave with full pay. And it cannot be extended without salary deduction. The employee shall be required to produce a certificate of the expectant partner's medical condition from a qualified medical practitioner or midwife.
                                                </p>

                                                <div class="form-group">
                                                    <label for="example-date-input" class="col-form-label">Starting Date</label>
                                                    <input class="form-control" type="date" required id="example-date-input" name="fromdate">
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-date-input" class="col-form-label">End Date</label>
                                                    <input class="form-control" type="date" required id="example-date-input" name="todate">
                                                </div>

                                                <!-- generates a dropdown (select) list in an HTML form for selecting a "Leave Type" -->
                                                <div class="form-group">
                                                    <label class="col-form-label">Your Leave Type</label>
                                                    <select class="custom-select" name="leavetype" autocomplete="off">
                                                        <option value="">Click here to select any ...</option>
                                                        <?php
                                                        //available leave types are dynamically fetched from the DB table(leave type)
                                                        $sql = "SELECT LeaveType from tblleavetype";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) { ?>
                                                                <option value="<?php echo htmlentities($result->LeaveType); ?>"><?php echo htmlentities($result->LeaveType); ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Describe Your Conditions</label>
                                                    <textarea class="form-control" name="description" rows="5" id="example-text-input"></textarea>
                                                </div>

                                                <button class="btn btn-primary" name="apply" id="apply" type="submit">SUBMIT</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content area end -->
            <!-- Footer area start -->
            <?php include '../includes/footer.php' ?>
            <!-- Footer area end -->
        </div>
        <!-- Page container area end -->
        <!-- Offset area start -->
        <div class="offset-area">
            <div class="offset-close"><i class="ti-close"></i></div>
        </div>
        <!-- Offset area end -->
        <!-- jQuery latest version -->
        <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
        <!-- Bootstrap 4 JS -->
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/metisMenu.min.js"></script>
        <script src="../assets/js/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/jquery.slicknav.min.js"></script>
        <!-- Other plugins -->
        <script src="../assets/js/plugins.js"></script>
        <script src="../assets/js/scripts.js"></script>
    </body>

    </html>

<?php } ?>