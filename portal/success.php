<?php include 'db.php'; ?>

<?php

    session_start();

    if (isset($_POST['login'])) {
        
        
        
        $myusername = mysqli_real_escape_string($connection,$_POST['user']);
        $mypassword = mysqli_real_escape_string($connection,$_POST['pass']);
        $dataEntryURL = "Admin/Data%20Entry/";
        $superAdminURL = "Admin/Super%20Admin/";
        $adminURL = "Admin/Admin/";
    
        $_SESSION['user'] = $myusername;
        

            $query = "SELECT userAcc_id FROM UserAccount WHERE userName = '$myusername' OR userAcc_id= '$myusername' and userPass = '$mypassword'"; #Data Entry Login

            $result = mysqli_query($connection,$query);

            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

            $typequery = "SELECT userType from UserAccount WHERE userName = '$myusername' OR userAcc_id = 'myusername
           ' AND userPass = '$mypassword'";

            $typeResult = mysqli_query($connection,$typequery);

            $row = mysqli_fetch_array($typeResult);

            $type = $row['userType'];

            $count = mysqli_num_rows($result);


            if($count == 1 && $type == 3) {

                $userType = "Data Entry";
                $_SESSION['type'] = $userType;
              
                header("location: Admin/Data%20Entry/");

            } else if($count == 1 && $type == 4) {
                
                $userType = "Super Admin";
                $_SESSION['type'] = $userType;
                header("location: Admin/Super%20Admin/");

            } else if($count == 1 && $type == 2) {
                
                $userType = "Admin";
                $_SESSION['type'] = $userType;
                header("location: Admin/Admin/");

            } else if($count == 1 && $type == 1) {
                $error = "You must log onto the mobile application!";
                echo '<script language="javascript">';
                echo 'alert("'. $error . '")';
                echo '</script>';

          } else if($count != 1) {
                
                //
                
                $error = "Your Login Name or Password is invalid";
                echo '<script language="javascript">';
                echo 'alert("'. $error . '")';
                echo '</script>';
                
                header("Location: index.php?error=Invalid%20Credentials");
          }
        }   else    {
                $error = "Please fill both fields.";
                echo '<script language="javascript">';
                echo 'alert("'. $error . '")';
                echo '</script>';
        header("Location: index.php?error=Please%20Fill%20All%20Fields");
        }
?>