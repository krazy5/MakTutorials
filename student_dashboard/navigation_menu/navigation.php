<?php
session_start();
     
      $student=$_SESSION['student'];
 
      if ($student==true) {
      
      }
      else{
        header("location:../../login/login.html");
      }

?>
 
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="../dashboard/dashboard.php">
        <img src="../image/logo.png" width="30" height="30" alt="Company Logo">
        Mak Tutorials
    </a>
    <div class="ml-auto">
        <a href="../../login/change_password_student.php" class="text-white">Change Password</a>
        <a href="../../login/logout.php" class="text-white ml-3">Logout</a>
    </div>
	
</nav>

        