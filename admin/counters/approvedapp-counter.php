<?php
// Include the database connection file
include '../../includes/dbconn.php';

// SQL query to select the id from tblleaves where Status is '1'
$sql = "SELECT id FROM tblleaves WHERE Status = '1'";
// Prepare the SQL query
$query = $dbh->prepare($sql);
// Execute the SQL query
$query->execute();
// Fetch all results as objects
$results = $query->fetchAll(PDO::FETCH_OBJ);
// Get the number of rows returned by the query
$leavtypcount = $query->rowCount();

// Output the count as HTML
echo htmlentities($leavtypcount);
