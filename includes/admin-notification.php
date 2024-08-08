<link rel="stylesheet" href="../assets/css/styles.css">

<?php
// Include the database connection file
include 'dbconn.php';

// Initialize the unread status
$isread = 0;

// Query to count the number of unread notifications
$sql = "SELECT id FROM tblleaves WHERE IsRead = :isread";
$query = $dbh->prepare($sql);
$query->bindParam(':isread', $isread, PDO::PARAM_STR); // Bind the unread status
$query->execute(); // Execute the query
$results = $query->fetchAll(PDO::FETCH_OBJ); // Fetch all results as objects
$unreadcount = $query->rowCount(); // Count the number of unread notifications
?>

<li class="dropdown">
    <!-- Dropdown icon with unread count -->
    <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
        <span><?php echo htmlentities($unreadcount); ?></span> <!-- Display unread count -->
    </i>
    <div class="dropdown-menu bell-notify-box notify-box">
        <!-- Notification title with unread count -->
        <span class="notify-title">You have <?php echo htmlentities($unreadcount); ?> <b>unread</b> notifications!</span>

        <div class="notify-list">
            <?php
            // Re-fetch notifications for detailed view
            $sql = "SELECT tblleaves.id AS lid, tblemployees.FirstName, tblemployees.LastName, tblemployees.EmpId, tblleaves.PostingDate
                            FROM tblleaves
                            JOIN tblemployees ON tblleaves.empid = tblemployees.id
                            WHERE tblleaves.IsRead = :isread";
            $query = $dbh->prepare($sql);
            $query->bindParam(':isread', $isread, PDO::PARAM_STR); // Bind the unread status
            $query->execute(); // Execute the query
            $results = $query->fetchAll(PDO::FETCH_OBJ); // Fetch all results as objects

            // Check if there are any notifications
            if ($query->rowCount() > 0) {
                foreach ($results as $result) {
            ?>
                    <!-- Display each notification -->
                    <a href="employeeLeave-details.php?leaveid=<?php echo htmlentities($result->lid); ?>" class="notify-item">
                        <div class="notify-thumb">
                            <i class="ti-comments-smiley btn-info"></i> <!-- Icon for the notification -->
                        </div>
                        <div class="notify-text">
                            <!-- Notification content -->
                            <p>
                                <b><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?>
                                    <br />(<?php echo htmlentities($result->EmpId); ?>)
                                </b> has recently applied for a leave.
                            </p>
                            <span>at <?php echo htmlentities($result->PostingDate); ?></span> <!-- Posting date -->
                        </div>
                    </a>
            <?php
                }
            }
            ?>
        </div>
    </div>
</li>