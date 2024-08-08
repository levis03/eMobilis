<?php
// Include the database connection file
include '../../includes/dbconn.php';

// Define the SQL query to select all employee IDs from the tblemployees table
$sql = "SELECT id FROM tblemployees";
// Prepare the SQL query for execution
$query = $dbh->prepare($sql);
// Execute the prepared SQL query
$query->execute();
// Fetch all results from the executed query as an array of objects
$results = $query->fetchAll(PDO::FETCH_OBJ);
// Get the total number of rows returned by the query
$empcount = $query->rowCount();

// Output the employee count, ensuring safe HTML output
echo htmlentities($empcount);
