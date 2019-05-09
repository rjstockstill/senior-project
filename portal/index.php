<?php include 'db.php'; ?>

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
                
             
          }
            {
                $error = "Please fill both fields.";
                echo '<script language="javascript">';
                echo 'alert("'. $error . '")';
                echo '</script>';
    }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Cinzel|Coda|Forum|Tinos|Tulpen+One" rel="stylesheet">
        <title>Medication Leaflet System</title>
    </head>
    <body>
        <div class="container">
            
            <div class="login-wrap">
                <img class= "logo" src="images/MLS-Logo.jpg" width="180" height="115" alt="Medication Leaflet System Logo">
                <form method="POST" action="">
                    <div class="login-info">
                        <input type="text" class="form-control" name="user" placeholder="Username or ID">
                    
                        <input type="password" class="form-control" name="pass" placeholder="Password">
                    </div>
                    <div class="buttons">
                        <button type="button" class ="button button-register" id="register">Register</button>
                        <button type="submit" class ="button button-login" name="login">Login</button>
                    </div>
                    <div class="forgot-pw">
                        <a href="forgotPW.php">Forgot Password?</a>
                    </div>
                </form>
                
                </div>
            </div>
     

        
    <script type="text/javascript">
            document.getElementById("register").onclick = function () {
                location.href="User/register.php";
            };
      
        
    </script>
        
    </body>
</html>