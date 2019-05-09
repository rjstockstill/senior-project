<?php 
    include '../../db.php'; 
    session_start();
    if($_SESSION['type'] == "Super Admin") {

        $myusername = $_SESSION['user'];

        }   
        else if($_SESSION['type'] == "Data Entry") {
            header("Location: ../../index.php?error=You%20must%be%a%super%20administrator!");
            exit();
        }
        else if($_SESSION['type'] == "Admin") {
            header("Location: ../../index.php?error=You%20must%be%a%super%20administrator!");
            exit();
        }
        else  {
            header("Location: ../../index.php?error=You%20must%20login!");
        }

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Update Account</title>
        <link rel="stylesheet" href="../style.css" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    </head>
    <body>
                <!-----Navigation Bar-------->
        <div class="nav">
            <div class="navbar-text">
                <a href="index.php">Super Administrator</a>
                
            </div>
            <div class="username">
                    <a href="update.php"><?php echo $myusername; ?></a>
            </div>
            <div class="logout-text">
                Logout
            </div>
            
            <a href="../../logout.php" class="logout-button"><img src="../../images/logout.png" width="25px" height="25px" alt="Logout"></a>
        </div>
        
        <div class="main">
            <h2>Change Password</h2>
                    <hr>
                     <form action="updateSuccess.php" method="post">
                         <div class="form-group row">
                             <label for="currentPW" class="col-sm-5 col-form-label">Current Password</label>
                             <div class="col-sm-6">
                                 <input type="password" class="form-control" name="currentPW" placeholder="Current Password">
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="currentPW" class="col-sm-5 col-form-label">New Password</label>
                             <div class="col-sm-6">
                                 <input type="password" class="form-control" name="newPW" placeholder="New Password">
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="currentPW" class="col-sm-5 col-form-label">Confirm Password</label>
                             <div class="col-sm-6">
                                 <input type="password" class="form-control" name="confirmPW" placeholder="Confirm Password">
                             </div>
                         </div>
                         <div class="text-center">
                             <input class="update-submit" type="submit" value="Change Password">
                         </div>
                         
                </form>
        </div>
    </body>
</html>