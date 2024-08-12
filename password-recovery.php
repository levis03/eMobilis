<?php
// Start or resume the session
session_start();

// Include the database connection file
include('includes/dbconn.php');

// Check if the 'change' button has been pressed
if (isset($_POST['change'])) {
    // Sanitize and retrieve form inputs
    $newpassword = $_POST['newpassword'];
    $empid = $_SESSION['empid']; // Retrieve the employee ID from the session

    // Hash the new password using bcrypt
    $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);

    // SQL query to update the password for the given employee ID
    $con = "UPDATE tblemployees SET Password=:newpassword WHERE id=:empid";
    $chngpwd1 = $dbh->prepare($con);
    $chngpwd1->bindParam(':empid', $empid, PDO::PARAM_INT); // Bind employee ID
    $chngpwd1->bindParam(':newpassword', $hashedPassword, PDO::PARAM_STR); // Bind new password
    $chngpwd1->execute(); // Execute the query

    // Set a success message
    $msg = "Your password has been successfully updated. Enter new credentials to continue.";
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Employee Leave Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- Modernizr for feature detection -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- Preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- Preloader area end -->
    <!-- Login area start -->
    <div class="login-area login-s2">
        <div class="container">
            <!-- Display error or success messages -->
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
            <div class="login-box ptb--100">
                <!-- Form to recover password -->
                <form method="POST" name="signin">
                    <div class="login-form-head">
                        <h4>Recover Your Password</h4>
                        <p>Please provide your employee details for recovery.</p>
                    </div>
                    <div class="login-form-body">
                        <!-- Email input field -->
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" id="exampleInputEmail1" name="emailid" autocomplete="off">
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <!-- Employee ID input field -->
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Employee ID</label>
                            <input type="text" id="exampleInputPassword1" name="empid" autocomplete="off">
                            <i class="ti-id-badge"></i>
                            <div class="text-danger"></div>
                        </div>
                        <!-- Submit button for recovery -->
                        <div class="submit-btn-area">
                            <button id="form_submit" name="submit" type="submit">PROCEED FOR RECOVERY <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Have an Account? <a href="index.php">Login Now</a></p>
                        </div>
                    </div>
                </form>
                <!-- Handle the recovery process -->
                <?php if (isset($_POST['submit'])) {
                    $empid = $_POST['empid'];
                    $email = $_POST['emailid'];
                    // SQL query to check if the provided email and employee ID match
                    $sql = "SELECT id FROM tblemployees WHERE EmailId=:email and EmpId=:empid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':email', $email, PDO::PARAM_STR); // Bind email
                    $query->bindParam(':empid', $empid, PDO::PARAM_STR); // Bind employee ID
                    $query->execute(); // Execute the query
                    $results = $query->fetchAll(PDO::FETCH_OBJ); // Fetch all results as objects

                    // Check if any results were returned
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                            $_SESSION['empid'] = $result->id; // Store the employee ID in the session
                        }
                ?>
                        <!-- Form to change the password -->
                        <div class="login-form-body">
                            <form method="POST" name="updatepwd">
                                <!-- New Password input field -->
                                <div class="form-gp">
                                    <label for="exampleInputEmail1">Enter New Password</label>
                                    <input type="password" id="exampleInputEmail1" name="newpassword" required autocomplete="off">
                                    <i class="ti-key"></i>
                                    <div class="text-danger"></div>
                                </div>
                                <!-- Confirm Password input field -->
                                <div class="form-gp">
                                    <label for="exampleInputPassword1">Confirm Password</label>
                                    <input type="password" id="exampleInputPassword1" name="confirmpassword" required autocomplete="off">
                                    <i class="ti-key"></i>
                                    <div class="text-danger"></div>
                                </div>
                                <!-- Submit button for password change -->
                                <div class="submit-btn-area">
                                    <button id="form_submit" name="change" type="submit">DONE <i class="ti-arrow-right"></i></button>
                                </div>
                            </form>
                        <?php } else { ?>
                            <!-- Show an alert if the details are invalid -->
                            <?php echo "<script>alert('Sorry, Invalid Details.');</script>"; ?>
                    <?php }
                } ?>
                        </div>
            </div>
        </div>
    </div>
    <!-- Login area end -->

    <!-- jQuery and JavaScript libraries -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>