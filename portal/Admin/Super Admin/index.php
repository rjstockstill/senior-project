<?php include '../../db.php'; 
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

<?php
    
    $type = gettype($myusername);

    if($type == "string"){
        $namequery = $connection -> prepare("SELECT first_name, last_name FROM UserAccount WHERE userName = ?");
        $namequery -> bind_param("s", $myusername);
        $namequery -> execute();
        $namequery->store_result();
        
        if($namequery->num_rows>0){
            $namequery->bind_result($firstname, $lastname);
            $namequery->fetch();
            $namequery->close();
            
      
        }   else{
            echo "Could not find that row...";
        }
    }   else if($type="integer"){
            $namequery = $connection -> prepare("SELECT first_name, last_name FROM UserAccount WHERE userAcc_id = ?");
            $namequery -> bind_param("i", $myusername);
            $namequery -> execute();
            $namequery->store_result();

            if($namequery->num_rows>0){
                $namequery->bind_result($firstname, $lastname);
                $namequery->fetch();
                $namequery->close();


            }   else{
                echo "Could not find that row...";
            }
        
    }
                                       
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Administrator Portal</title>
        <link type="text/css" rel="stylesheet" href="../style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <!-----We're not going to use bootstrap with the super administrator portal because it takes away the original styling.-------->
    </head>
    <body>
        
        <!-----Navigation Bar-------->
        <div class="nav">
            <div class="navbar-text">
                <a href="index.php">Super Administrator</a>
                
            </div>
            <div class="username">
                    <a href="update.php"><?php 
                        
                        echo  "$lastname, $firstname"; ?></a>
            </div>
            <div class="logout-text">
                Logout
            </div>
            
            <a href="../../logout.php" class="logout-button"><img src="../../images/logout.png" width="25px" height="25px" alt="Logout"></a>
        </div>
        
        <!----Create data entry users----->
        <div class="fixed manage_admin">
            <span onclick="openData()">Manage Administrative Users</span>
            <div class="overlay" id="manageAdmin">
                <a href="javascript:void(0)" class="closebtn" onclick="closeData()">&times;</a>
                <div class="overlay-content">
                    <a href="register.php">Create New User</a>
                    <a href="manageAccounts.php">View Administrative Users</a>
                </div>
            </div>    
        </div>
            
        <!----View website reports---->

        <div class="fixed reports">
            <span onclick="openReports()">Reports</span>
            <div class="overlay overlay-reports" id="viewReports">
                <a href="javascript:void(0)" class="closebtn" onclick="closeReports()">&times;</a>
                <div class="overlay-content">
                    <a href="reportForm.php">Generate Report</a>
                    <a href="#">View Reports</a>
                </div>
            </div>    
        </div>
        <script>
            function openData() {
                document.getElementById("manageAdmin").style.width = "418px";
            }
            function closeData() {
                document.getElementById("manageAdmin").style.width = "0%";
            }
            function openReports() {
                document.getElementById("viewReports").style.width = "418px";
            }
            function closeReports() {
                document.getElementById("viewReports").style.width = "0%";
            }
        </script>
    </body>
</html>
