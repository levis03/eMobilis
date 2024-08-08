<?php
// Database connection parameters
define('DB_HOST', 'localhost');      // Database host (usually 'localhost' for local development)
define('DB_USER', 'levis');           // Database username
define('DB_PASS', 'levis@123');       // Database password
define('DB_NAME', 'employeeleavedb'); // Database name

try {
    // Attempt to create a new PDO instance to connect to the MySQL database
    $dbh = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, // Data source name (DSN)
        DB_USER,   // Database username
        DB_PASS,   // Database password
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'") // Set character encoding to UTF-8
    );
} catch (PDOException $e) {
    // If connection fails, catch the PDOException
    echo "Looks like you don't have any database/connection for this project. Please check your Database Connection and Try Again! </br>";
    exit("Error: " . $e->getMessage()); // Display the error message and terminate the script
}
