<div class="user-profile pull-right">
   <!-- User avatar image -->
   <img class="avatar user-thumb" src="../assets/images/avatar.jpg" alt="avatar">

   <!-- User name with dropdown toggle -->
   <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
      <!-- Include a PHP script to display the logged-in user's name -->
      <?php include 'logged.php'; ?>
      <i class="fa fa-angle-down"></i>
   </h4>

   <!-- Dropdown menu for user profile options -->
   <div class="dropdown-menu">
      <!-- Link to view the user's profile -->
      <a class="dropdown-item" href="my-profile.php">View Profile</a>

      <!-- Link to change the user's password -->
      <a class="dropdown-item" href="change-password-employee.php">Password</a>

      <!-- Link to log out of the account -->
      <a class="dropdown-item" href="logout.php">Log Out</a>
   </div>
</div>