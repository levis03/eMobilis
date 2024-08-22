<?php
// Include the database connection file
include '../../includes/dbconn.php';

// SQL query to select the id from tblleaves where Status is '2' and the PostingDate is within the last 24 hours
$sql = "SELECT id FROM tblleaves WHERE Status = '2' AND PostingDate >= NOW() - INTERVAL 1 DAY";
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
