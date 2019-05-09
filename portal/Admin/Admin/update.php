<?php 
    include '../../db.php'; 
    session_start();
    $myusername = $_SESSION['user'];

?>

<?php
    
if(isset($_POST['submit'])){
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
      
        }   else{
            echo "Could not find that row...";
        }
    }

//if($userPass == $_POST['currentPW']){
    if(isset($_POST['currentPW']) && isset($_POST['newPW']) && isset($_POST['confirmPW']) && !empty($_POST['currentPW']) && !empty($_POST['newPW']) && !empty($_POST['confirmPW'])){
  if(password_verify($_POST['currentPW'],$userPass) || $userPass == $_POST['currentPW']){
        

    if(isset($_POST['newPW']) && isset($_POST['confirmPW']) && isset($_POST['currentPW'])){
        if($_POST['newPW'] == $_POST['confirmPW']){
            $newPW = $_POST['newPW'];
            $hashed_password = password_hash($newPW, PASSWORD_DEFAULT);
            $query = "UPDATE UserAccount SET userPass = ? WHERE userName = ?";
            $updateUser = $connection->prepare($query);
            $updateUser->bind_param("ss", $hashed_password, $myusername);
            $updateUser->execute();

            if ($updateUser->execute()) {

                

                $updateUser->close();

                    } else {

                        $error = "Error updating password";
                        echo '<script language="javascript">';
                        echo 'alert("'. $error . '")';
                        echo '</script>';
                    }
        }   else{
            echo "New passwords do not match";
        }
    }
    } else{
            echo "Current password does not match stored password";
        }
    }
    
    if(isset($_POST['zip']) && !empty($_POST['zip'])){
        $zip = $_POST['zip'];
    
            $query = "UPDATE UserAccount SET zip = ? WHERE userName = ?";
            $updateUser = $connection->prepare($query);
            $updateUser->bind_param("is", $zip, $userAcc);
            $updateUser->execute();

            if ($updateUser->execute()) {

              

                $updateUser->close();

                    } else {

                        $error = "Error updating zip code";
                        echo '<script language="javascript">';
                        echo 'alert("'. $error . '")';
                        echo '</script>';
                    }
        }  
        
    
    if(isset($_POST['state']) && !empty($_POST['state'])){
        $state = $_POST['state'];
    
            $query = "UPDATE UserAccount SET state = ? WHERE userName = ?";
            $updateUser = $connection->prepare($query);
            $updateUser->bind_param("ss", $state, $userAcc);
            $updateUser->execute();

            if ($updateUser->execute()) {

            

                $updateUser->close();

                    } else {

                        $error = "Error updating state";
                        echo '<script language="javascript">';
                        echo 'alert("'. $error . '")';
                        echo '</script>';
                    }
        }
    
    if(isset($_POST['city']) && !empty($_POST['city'])){
        $city = $_POST['city'];
    
            $query = "UPDATE UserAccount SET city = ? WHERE userName = ?";
            $updateUser = $connection->prepare($query);
            $updateUser->bind_param("ss", $city, $userAcc);
            $updateUser->execute();

            if ($updateUser->execute()) {

               

                $updateUser->close();

                    } else {

                        $error = "Error updating city";
                        echo '<script language="javascript">';
                        echo 'alert("'. $error . '")';
                        echo '</script>';
                    }
        }

    if(isset($_POST['address1']) && !empty($_POST['address1'])){
        $address1 = $_POST['address1'];
    
            $query = "UPDATE UserAccount SET address2 = ? WHERE userName = ?";
            $updateUser = $connection->prepare($query);
            $updateUser->bind_param("ss", $address1, $userAcc);
            $updateUser->execute();

            if ($updateUser->execute()) {

                $success = "User '. $myusername .' has been updated.";
                echo '<script language="javascript">';
                echo 'alert("'. $success . '")';
                echo '</script>';

                $updateUser->close();

                    } else {

                        $error = "Error updating Address 1 ";
                        echo '<script language="javascript">';
                        echo 'alert("'. $error . '")';
                        echo '</script>';
                    }
        
    }
    if(isset($_POST['address2']) && !empty($_POST['address2'])){
        $address2 = $_POST['address2'];
    
            $query = "UPDATE UserAccount SET address2 = ? WHERE userName = ?";
            $updateUser = $connection->prepare($query);
            $updateUser->bind_param("ss", $address2, $userAcc);
            $updateUser->execute();

            if ($updateUser->execute()) {

                

                $updateUser->close();

                    } else {

                        $error = "Error updating Address 2 ";
                        echo '<script language="javascript">';
                        echo 'alert("'. $error . '")';
                        echo '</script>';
                    }
        
    }
 header("location:settings.php?success=User%20updated!");
}

?>