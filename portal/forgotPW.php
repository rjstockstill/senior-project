<?php
    include 'db.php'; 
?>

<?php

    $n=10; 
    function getPass($n) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $generatedPassword = ''; 

        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $generatedPassword .= $characters[$index]; 
        } 

        return $generatedPassword; 
    } 

    if(isset($_POST['submit'])){
        $userID = mysqli_real_escape_string($connection, $_POST['user_id']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = getPass($n);
        $hashed_password = md5($password);
        
        if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
            $grabID = $connection -> prepare("UPDATE UserAccount SET userPass = ? WHERE userAcc_id = ?");
            $grabID -> bind_param("ss", $hashed_password, $userID);
            $grabID -> execute();
            

            if($grabID->execute()){
                $grabID->store_result();
                # $grabID->bind_result($user_id);
                $grabID->fetch();
                $grabID->close();
                
                echo '<script language="javascript">';
                echo 'alert("Your new password is: '. $password . '.")';
                echo '</script>';
                
            }   else{
                $error =  "Could not find that user ID...";
                echo '<script language="javascript">';
                echo 'alert("'. $error . '")';
                echo '</script>';
            }
        }
        
        else if(isset($_POST['email']) && !empty($_POST['email'])){
            $grabID = $connection -> prepare("UPDATE UserAccount SET userPass = ? WHERE email = ?");
            $grabID -> bind_param("ss", $hashed_password, $email);
            $grabID -> execute();

            if($grabID->execute()){
                $grabID->store_result();
                # $grabID->bind_result($userID);
                $grabID->fetch();
                $grabID->close();
                
                echo '<script language="javascript">';
                echo 'alert("Your new password is: '. $password . '.")';
                echo '</script>';
                
            }   else{
                $error = "Could not find that email...";
                echo '<script language="javascript">';
                echo 'alert("'. $error . '")';
                echo '</script>';
            }
        }   else{
                $error = "Please enter either your user ID or email";
                echo '<script language="javascript">';
                echo 'alert("'. $error . '")';
                echo '</script>';
        }
        
        
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Forgot Password | MLS</title>
        <meta charset="UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" type="text/css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cinzel|Coda|Forum|Tinos|Tulpen+One" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>Forgot Password</h1>
            <hr>
                <form action="" method="post" class="forgotPW-form">
                    Please insert your user ID or email to generate a new password.<br>
                    
                    <input type="text" name="user_id" class="forgotPW-input" placeholder="User ID"><br>
                    <input type="email" name="email" class="forgotPW-input" placeholder="E-mail"><br> 
                    <input type="submit" name="submit" value="Get New Password" class="newPassButton">
                    <br>
                    <a href="index.php">Back to Login</a>
                </form>
            </div>
        
    </body>
</html>