<?php 
    include '../../db.php'; 
    session_start();
    $myusername = $_SESSION['user'];

?>

<?php
    
    $userAcc = $_SESSION['user'];
    $type = gettype($userAcc);

    
        
    if($type = "integer"){
     
        $namequery = $connection -> prepare("SELECT userPass FROM UserAccount WHERE userName = ? OR userAcc_id = ?");
        $namequery -> bind_param("ss", $userAcc, $userAcc);
        $namequery -> execute();
        $namequery->store_result();
        
        if($namequery->num_rows>0){
            $namequery->bind_result($userPass);
            $namequery->fetch();
            $namequery->close();
            echo $userPass;
      
        }   else{
            echo "Could not find that row...";
        }
    }   else if($type = "string"){
        $namequery = $connection -> prepare("SELECT userPass FROM UserAccount WHERE userName = ? OR userAcc_id = ?");
        $namequery -> bind_param("ss", $userAcc, $userAcc);
        $namequery -> execute();
        $namequery->store_result();
        
        if($namequery->num_rows>0){
            $namequery->bind_result($userPass);
            $namequery->fetch();
            $namequery->close();
            echo $userPass;
            echo $_POST['currentPW'];
      
        }   else{
            echo "Could not find that row...";
        }
    }

#password_verify not working 

if(isset($_POST['newPW']) && isset($_POST['confirmPW']) && isset($_POST['currentPW'])){
    
    

  if(password_verify($_POST['currentPW'],$userPass) || ($_POST['currentPW']== $userPass)){
        
      if($_POST['newPW'] == $_POST['confirmPW']){
            $newPW = $_POST['newPW'];
            $hashed_password = password_hash($newPW, PASSWORD_DEFAULT);
            $query = "UPDATE UserAccount SET userPass = ? WHERE userName = ?";
            $updateUser = $connection->prepare($query);
            $updateUser->bind_param("ss", $hashed_password, $myusername);
            $updateUser->execute();

            if ($updateUser->execute()) {

                header("location: update.php?success=password%20changed");
                
                $success = "User '. $myusername .' has been updated.";
                echo '<script language="javascript">';
                echo 'alert("'. $success . '")';
                echo '</script>';

                $updateUser->close();

                    } else {

                        $error = "There's a problem...";
                        echo '<script language="javascript">';
                        echo 'alert("'. $error . '")';
                        echo '</script>';
                    }
        }   else{
          header("location: update.php?error=New%20passwords%20do%20not%20match%20stored%20password");
        }
    }
     else{
         header("location: update.php?error=Current%20password%20does%20not%20match%20stored%20password");
           
        }
     
}
?>
