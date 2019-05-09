<?php include '../../db.php'; ?>

<?php
   if(isset($_POST['username']) !== "") {
    
        
        $date = date('Y-m-d H:i:s');
        
    
        
        $password = $_POST['password'];
        
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
       $type = mysqli_real_escape_string($connection, $_POST['userTypeRadio']);
       $hashed_password = password_hash($password, PASSWORD_DEFAULT);
       $userStatus = 2;
        
        
       if($type=="DataEntry"){
            $userType = 3;
        }else if($type=="Administrator"){
            $userType = 2;
        }
       
    
        $user_id = "SELECT user_id FROM User WHERE username = $username";
        
        $stmt = $connection->prepare("INSERT into UserAccount(userName, userPass, first_name, last_name, userType, status) VALUES( ?, ?, ?, ?, ?, ?)");
       $stmt->bind_param("ssssii", $username, $hashed_password, $firstname, $lastname, $userType, $userStatus);
       $stmt -> execute();
       
        
        if($stmt->execute()) {
            
                $stmt->close();
            
            }  else {
                header("Location: manageAccounts.php?success=User%20Created");
            }
        
   }   else{
        header("Location: register.php?error=Please%20Fill%20All%20Fields");
   }
?>
