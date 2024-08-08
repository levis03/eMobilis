<?php
// Include database connection file
include '../includes/dbconn.php';

// Get the employee ID from the session
$eid = $_SESSION['eid'];

// SQL query to fetch the employee's first name, last name, and employee ID based on the session employee ID
$sql = "SELECT FirstName, LastName, EmpId FROM tblemployees WHERE id = :eid";

// Prepare the SQL query for execution
$query = $dbh->prepare($sql);

// Bind the employee ID parameter to the SQL query
$query->bindParam(':eid', $eid, PDO::PARAM_STR);

// Execute the prepared SQL query
$query->execute();

// Fetch all results as an array of objects
$results = $query->fetchAll(PDO::FETCH_OBJ);

// Initialize a counter (not used in this snippet)
$cnt = 1;

// Check if any rows were returned
if ($query->rowCount() > 0) {
    // Iterate through each result
    foreach ($results as $result) { ?>
        <!-- Display the employee's full name and employee ID -->
        <p style="color:white;"><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?></p>
        <span><?php echo htmlentities($result->EmpId); ?></span>
<?php
    }
}
?>