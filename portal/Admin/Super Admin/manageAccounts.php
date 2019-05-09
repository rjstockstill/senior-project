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

    $query = 'SELECT * FROM UserAccount WHERE userType = 2 OR userType= 3 OR userType = 4';
    $message = mysqli_query($connection, $query);
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


<?php 

    if(isset($_GET['action']) && isset($_GET['userAcc_id'])){
        if ($_GET['action'] == 'view'){
            $userAcc_id = $_GET['userAcc_id'];

            $viewAdmin = $connection->prepare('SELECT userAcc_id, userName, first_name, last_name, userType, status, city, state, zip, address1, address2, dob, created FROM UserAccount WHERE userAcc_id = ?'); 
            $viewAdmin->bind_param("i", $userAcc_id); 
            $viewAdmin->execute(); 
            $viewAdmin->store_result(); 
            if($viewAdmin->num_rows > 0){ 
               $viewAdmin->bind_result($userAcc_id, $userName, $first_name, $last_name, $userType, $status, $city, $state, $zip, $address1, $address2, $dob, $created); 
               $viewAdmin->fetch(); 
                $viewAdmin->close();

    
}   else{
    echo "Error viewing informtaion";
} 

       
    }
    }
?>

<?php 

    if(isset($_GET['action']) && isset($_GET['userAcc_id'])){
        if ($_GET['action'] == 'remove'){
            $userAcc_id = $_GET['userAcc_id'];
          
           
            $query = "DELETE FROM UserAccount WHERE userAcc_id = ?";
            $deleteAdmin = $connection->prepare($query);
            $deleteAdmin->bind_param("i", $userAcc_id);
            $deleteAdmin->execute();
            
            if ($deleteAdmin->affected_rows>0){
                $success = "UserAccount '. $userAcc_id .' has been removed.";
                echo '<script language="javascript">';
                echo 'alert("'. $success . '")';
                echo '</script>';
            }  
            else{
                echo "Error removing administrator.";
            }
           
             
            
            
        }
    }
?>

<?php 
    

    if(isset($_GET['action']) && isset($_GET['user_id'])){
        if ($_GET['action'] == 'block'){
            $user_id = $_GET['user_id'];
            $date = date('Y-m-d H:i:s');
           
            
            $reason = "GENERIC REASON";
            
           # $query = "INSERT into Blocked VALUES ($user_id, $reason)"
            
           $query = "UPDATE User SET status = 3 WHERE user_id = $user_id";
           $query = "INSERT INTO Blocked(user_id, reason, blockDate) Values('$user_id', '$reason', '$date' )";
            
            # $query = "DELETE from User WHERE user_id = $user_id";
            
            if(!mysqli_query($connection, $query)){
                die(mysqli_error($connection));
            }
            else {
                header("Location: manageDataEntry.php?success=User%20Removed");
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Manage Accounts</title>
        <link rel="stylesheet" href="../style.css" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    </head>
    <body>
        <!-------Navigation Bar----------->
            <div class="nav">
                <div class="navbar-text">
                    <a href="index.php">Super Administrator</a>
                </div>
                <div class="username">
                    <a href="update.php"><?php echo "$lastname, $firstname"; ?></a>
                </div>
                <div class="logout-text">
                    Logout
                </div>

                <a href="../../logout.php" class="logout-button"><img src="../../images/logout.png" width="25px" height="25px" alt="Logout"></a>
        </div>
        <div class="header">
                
                <h1>Administrative Users</h1>
                <hr>
            </div>
        <div class="manageAccounts">
            <table class="table table-hover table-fixed fixed_header">
                <thead>
                    <tr>
                        
                        <th scope="col">Username</th>
                        <th scope="col">Status</th>
                        <th scope="col">Type</th>
                        <th colspan="2" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        
                        
                       <?php while($row = mysqli_fetch_assoc($message)) : ?>
                        <?php if ($row['userType'] == 1){
                            $type = "User";
                        } else if ($row['userType'] == 2){
                                    $type = "Administrator";
                                } else if ($row['userType'] == 3) {
                                    $type = "Data Entry";
                                } else if ($row['userType'] == 4) {
                                    $type = "Super Administrator";
                                } else {
                                    $type = "Invalid";
                                }
                              ?>
                               <?php if ($row['status'] == 1){
                                    $status = "Conditional";    #Strictly for those who try to register as doctors
                                } else if ($row['status'] == 2){
                                    $status = "Active";
                                } else if ($row['status'] == 3) {
                                    $status = "Banned";
                                } else {
                                    $status = "Invalid";
                                }
                              ?>
                              
                              
                              <td><?php echo $row['userName'];?></td>
                              <td><?php echo $status;?></td>
                              <td><?php echo $type;?></td>
                              <td colspan="2">
                                  <a  href="manageAccounts.php?action=view&userAcc_id=<?php echo $row['userAcc_id'];?>" id="showUserDetails" >View </a>
                                  <a href="manageAccounts.php?action=remove&userAcc_id=<?php echo $row['userAcc_id'];?>"><i class="fas fa-trash-alt"></i> Remove Administrator</a>    
                              </td>
                            </tr>
                        </tbody>
                        <?php endwhile; ?>
                                    </table>
                    
                </div>
        <div class="viewUserDetail" id="userDetails" >
            <?php 
            if(isset($_GET['action']) && isset($_GET['userAcc_id'])){
        if ($_GET['action'] == 'view'){
            
                echo "User Account ID : $userAcc_id";
                echo "<br>";
                echo "Username: $userName";
                echo "<br>";
                echo "User Since: $created";
                echo "<br>";
                echo "Name: $first_name $last_name";
                echo "<br>";
                
                if ($userType == 1){
                            $type = "User";
                        } else if ($userType == 2){
                                    $uType = "Administrator";
                                } else if ($row['userType'] == 3) {
                                    $uType = "Data Entry";
                                } else if ($userType == 4) {
                                    $uType = "Super Administrator";
                                } else {
                                    $uType = "Invalid";
                                }
            echo "User Type: $uType";
                echo "<br>";
                echo "Status: $status";
                echo "<br>";
                echo "Address: $address1 $address2 $city, $state $zip";
                echo "<br>";
                echo "Date of Birth: $dob";
            
        }
            }
            
            ?>
            
        </div>
        
        <script type="text/javascript">
            
           document.getElementById("showUserDetails").addEventListener('click', function(){
                    document.querySelector('.viewUserDetail').style.display = "flex";
            })
            
            /*
            
            function showUser() {
                
                var user = document.getElementById("userDetails");
                
                if (user.style.display === "none") {
                    user.style.display = "block";
                } else {
                user.style.display = "none";
                }
            }
            */
        </script>
    </body>
</html>

