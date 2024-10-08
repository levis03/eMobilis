<?php

/**
 * Employee Login Panel
 *
 * This script handles the employee login functionality.
 *
 * @author Levis Maina
 * @version 1.1
 */

// Start the session
session_start();

// Initialize error message variable
$msg = '';

// Include the database connection file
include('includes/dbconn.php');

// Check if the signin form has been submitted
if (isset($_POST['signin'])) {
    // Sanitize and retrieve form inputs
    $uname = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Prepare the SQL query to retrieve the employee data by email
    $sql = "SELECT id, Password, Status FROM tblemployees WHERE EmailId = :uname";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uname', $uname, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($result) {
        // First, try to verify with the new bcrypt hash
        if (password_verify($password, $result->Password)) {
            // Correct bcrypt password, proceed to login
            $_SESSION['eid'] = $result->id;
            $_SESSION['emplogin'] = $uname;
            session_regenerate_id(true);
            echo "<script type='text/javascript'> document.location = 'employees/leave.php'; </script>";
            exit;
        }
        // If bcrypt fails, fall back to checking with md5 for legacy passwords
        elseif ($result->Password === md5($password)) {
            // Update the old md5 password to bcrypt
            $newHashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateSql = "UPDATE tblemployees SET Password = :newPassword WHERE id = :id";
            $updateQuery = $dbh->prepare($updateSql);
            $updateQuery->bindParam(':newPassword', $newHashedPassword, PDO::PARAM_STR);
            $updateQuery->bindParam(':id', $result->id, PDO::PARAM_INT);
            $updateQuery->execute();

            // Proceed with login
            $_SESSION['eid'] = $result->id;
            $_SESSION['emplogin'] = $uname;
            session_regenerate_id(true);
            echo "<script type='text/javascript'> document.location = 'employees/leave.php'; </script>";
            exit;
        } else {
            // Incorrect password
            $msg = "Incorrect password. Please try again.";
        }
    } else {
        // Incorrect email
        $msg = "Incorrect email address. Please try again.";
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
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- Preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- Preloader area end -->
    <!-- Login area start -->
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <!-- Login form -->
                <form method="POST" name="signin">
                    <div class="login-form-head">
                        <h4>Employee Login Panel</h4>
                        <p>Employee Leave Management System</p>
                        <?php if ($msg) { ?>
                            <div class="errorWrap"><strong>Error</strong>: <?php echo htmlentities($msg); ?> </div>
                        <?php } ?>
                    </div>
                    <div class="login-form-body">
                        <!-- Email input -->
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" id="username" name="username" autocomplete="off" required>
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <!-- Password input -->
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="password" name="password" autocomplete="off" required>
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <!-- Remember Me checkbox and Forgot Password link -->
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                    <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <a href="password-recovery.php">Forgot Password?</a>
                            </div>
                        </div>
                        <!-- Submit button -->
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit" name="signin">Login <i class="ti-arrow-right"></i></button>
                        </div>
                        <!-- Footer with Admin Panel link -->
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted"><a href="admin/index.php">Go to Admin Panel</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Login area end -->

    <!-- Scripts -->
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