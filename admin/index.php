<?php
session_start(); // Start the session to handle user authentication

include('../includes/dbconn.php'); // Include the database connection file

// Check if the form has been submitted
if (isset($_POST['signin'])) {
    $uname = $_POST['username']; // Get the username from the form
    $password = md5($_POST['password']); // Hash the password using MD5

    // SQL query to select the username and password from the admin table
    $sql = "SELECT UserName, Password FROM admin WHERE UserName=:uname and Password=:password";
    $query = $dbh->prepare($sql); // Prepare the SQL statement
    $query->bindParam(':uname', $uname, PDO::PARAM_STR); // Bind the username parameter
    $query->bindParam(':password', $password, PDO::PARAM_STR); // Bind the password parameter
    $query->execute(); // Execute the query

    $results = $query->fetchAll(PDO::FETCH_OBJ); // Fetch all results

    // Check if any rows were returned (i.e., login was successful)
    if ($query->rowCount() > 0) {
        $_SESSION['alogin'] = $_POST['username']; // Set session variable for logged in user
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>"; // Redirect to dashboard
    } else {
        echo "<script>alert('Invalid Details');</script>"; // Display error if login fails
    }
}
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Panel</title>
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
    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->

    <!-- login area start -->
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <!-- Login form -->
                <form name="signin" method="POST">
                    <div class="login-form-head">
                        <h4>ADMIN PANEL</h4>
                        <p>Employee Leave Management System</p>
                    </div>
                    <div class="login-form-body">
                        <!-- Username field -->
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" id="exampleInputEmail1" name="username" autocomplete="off" required>
                            <i class="ti-user"></i>
                            <div class="text-danger"></div>
                        </div>
                        <!-- Password field -->
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="exampleInputPassword1" name="password" autocomplete="off" required>
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>

                        <!-- Submit button -->
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit" name="signin">Submit <i class="ti-arrow-right"></i></button>
                        </div>
                        <!-- Footer with link to go back -->
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted"><a href="../index.php"><i class="ti-arrow-left"></i> Go Back</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

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