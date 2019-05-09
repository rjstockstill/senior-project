<?php include '../../db.php'; 
    
    session_start();

    if($_SESSION['type'] == "Admin") {

        $myusername = $_SESSION['user'];

        }   
        else if($_SESSION['type'] == "Super Admin") {
            header("Location: ../../index.php?error=You%20must%be%an%administrator!");
            exit();
        }
        else if($_SESSION['type'] == "Data Entry") {
            header("Location: ../../index.php?error=You%20must%be%an%administrator!");
            exit();
        }
        else  {
            header("Location: ../../index.php?error=You%20must%20login!");
        }
?>
<?php
   if(isset($_GET['action']) && isset($_GET['userAcc_id'])){
        if ($_GET['action'] == 'viewUser'){
            $userAcc_id = $_GET['userAcc_id'];

            $viewUser = $connection->prepare('SELECT userAcc_id, userName, first_name, last_name, userType, status, city, state, zip, address1, address2, dob, created FROM UserAccount WHERE userAcc_id = ?'); 
            $viewUser->bind_param("i", $userAcc_id); 
            $viewUser->execute(); 
            $viewUser->store_result(); 
            if($viewUser->num_rows > 0){ 
               $viewUser->bind_result($userAcc_id, $userName, $first_name, $last_name, $userType, $status, $city, $state, $zip, $address1, $address2, $dob, $created); 
             
                
               $viewUser->fetch(); 
               $viewUser->close();

    
}   else{
    echo "Error viewing information";
} 

       
    }
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


<?php
    $query = 'SELECT * FROM ConfirmLicense';
    $license = mysqli_query($connection, $query);

    if(isset($_GET['action']) && isset($_GET['user_id'])){
        if ($_GET['action'] == 'deny'){
            $status = 2;
            $doc_userAcc_id = $_GET['user_id'];
            
            $query = "UPDATE UserAccount SET status = ? WHERE userAcc_id = ?";
            $updateDoc = $connection->prepare($query);
            $updateDoc->bind_param("ii", $status, $doc_userAcc_id);
            $updateDoc->execute();
            
            if ($updateDoc->execute()) { 
                    $updateDoc->close();
                    
                $query = "DELETE FROM ConfirmLicense WHERE user_id = ?";
                    $deleteFromConfirm = $connection->prepare($query);
                    $deleteFromConfirm -> bind_param("i", $doc_userAcc_id);
                    $deleteFromConfirm -> execute();

                    } else {

                    header("Location: index.php?success=user%20%status%20updated");
                }
            
        }
    }

?>

<?php

    if(isset($_GET['action']) && isset($_GET['med_id'])){
        if ($_GET['action'] == ''){
            $type = 1;
            $doc_userAcc_id = $_GET['user_id'];
            
            $query = "UPDATE UserAccount SET type = ? WHERE userAcc_id = ?";
            $updateDoc = $connection->prepare($query);
            $updateDoc->bind_param("ii", $type, $doc_userAcc_id);
            $updateDoc->execute();
            
            if ($updateDoc->execute()) { 
                    $updateDoc->close();

                } else {

                    header("Location: index.php?success=user%20%status%20updated");
                }
            
        }
    }

?>
<?php 
    $query = 'SELECT * FROM UserAccount WHERE userType = 1';
    $userAccounts = mysqli_query($connection, $query);

    if(isset($_GET['action']) && isset($_GET['userAcc_id'])){
        if ($_GET['action'] == 'block'){
            $userAcc_id = $_GET['userAcc_id'];
            
            $status= 3;
           
            $query = "UPDATE UserAccount SET status = ? WHERE userAcc_id = ?";
            $updateUserAccount = $connection->prepare($query);
            $updateUserAccount->bind_param("ii", $status, $userAcc_id);
            $updateUserAccount->execute();
            
            
            
            
            if ($updateUserAccount->execute()) { 
                
                //It worked
                
                $success = "UserAccount '. $userAcc_id .' has been blocked.";
                echo '<script language="javascript">';
                echo 'alert("'. $success . '")';
                echo '</script>';
                
                $updateUserAccount->close();
                
            } else {
                
                $error = "There's a problem...";
                echo '<script language="javascript">';
                echo 'alert("'. $error . '")';
                echo '</script>';
            }
            
            
        }
    }
?>

<?php 

    if (isset($_GET['block_reason'])){
        $reason = $_POST['block_reason'];

        $blockInsert = $connection->prepare("INSERT INTO Blocked(userAcc_id, reason) VALUES (?, ?)");
        $blockInsert->bind_param("is", $status, $reason);
        $blockInsert->execute();

        if ($blockInsert->execute()) { 
                    $blockInsert->close();

                } else {

                    $success = "User '. $userAcc_id .' has been blocked.";
                    echo '<script language="javascript">';
                    echo 'alert("'. $success . '")';
                    echo '</script>';
                }
        
    }
    
?>


<?php 
    $query = 'SELECT * FROM Medicine';
    $medicine = mysqli_query($connection, $query);


 if(isset($_GET['action']) && isset($_GET['med_id'])){
        if ($_GET['action'] == 'viewMedDetail'){
            $med_id = $_GET['med_id'];
            
           $medicineQuery = $connection -> prepare("SELECT med_id, med_name, general_name, med_manufacturer, med_purpose, med_dosage, med_reactions, med_warnings, med_ndc FROM Medicine WHERE med_id = ? ");
                       $medicineQuery->bind_param("i", $med_id); 
                        $medicineQuery->execute();
                        $medicineQuery->store_result();

                        if($medicineQuery->num_rows>0){
                            $medicineQuery->bind_result($med_id, $medName, $genName, $manufac, $purpose, $dosage, $reactions, $warnings, $ndc);
                           $medicineQuery->fetch(); 
                          
                            $medicineQuery->close();

            }   else{
                echo "Couldn't find that row...";
                 }

        }
    }
?>


<?php
	$query = "select * from FlaggedAccount";
	$overview = mysqli_query($connection, $query);

		

?>

<?php 
    $query = 'SELECT * FROM Pharmacies';
    $pharmacies = mysqli_query($connection, $query);

    if(isset($_GET['action']) && isset($_GET['pharm_id'])){
        if ($_GET['action'] == 'delete'){
            $pharm_id = $_GET['pharm_id'];
            
            $query = "DELETE from Pharmacies WHERE pharm_id = ?";
            
            $removePharm = $connection->prepare($query);
            $removePharm->bind_param("i", $pharm_id);
            $removePharm->execute();
            
           if ($removePharm->execute()) { 
                    $removePharm->close();

                } else {

                    $success = "Pharmacy ID: '. $pharm_id .'  has been removed.";
                    echo '<script language="javascript">';
                    echo 'alert("'. $success . '")';
                    echo '</script>';
                }
        }
    }
?>
<?php
    
    if(isset($_POST['submitPharm'])){
        
         $pharmName = mysqli_real_escape_string($connection, $_POST['pharmName']);
        $pharmAddress = mysqli_real_escape_string($connection, $_POST['pharmAddress']);
        $pharmCity = mysqli_real_escape_string($connection, $_POST['pharmCity']);
        $pharmState = mysqli_real_escape_string($connection, $_POST['pharmState']);
        $pharmZIP = mysqli_real_escape_string($connection, $_POST['pharmZip']);
        $pharmNum = mysqli_real_escape_string($connection, $_POST['pharmNumber']);
        
         $query ="INSERT INTO Pharmacies(pharm_name, pharm_address, pharm_city, pharm_state, pharm_zip, pharm_num) VALUES (?, ?, ?, ?, ?, ?)";
            
            $addPharmacy = $connection->prepare($query);
            $addPharmacy->bind_param("ssssis", $pharmName, $pharmAddress, $pharmCity, $pharmState, $pharmZIP, $pharmNum);

            $addPharmacy->execute();
        
            if($addPharmacy->execute()){
                 $success = "Success adding pharmacy!";
                        echo '<script language="javascript">';
                        echo 'alert("'. $success . '")';
                        echo '</script>';
            }   else{
                        $error = "Error adding pharmacy...";
                        echo '<script language="javascript">';
                        echo 'alert("'. $error . '")';
                        echo '</script>';
            }
        
    }

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Administrator</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css">
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" crossorigin="anonymous" type="text/javascript"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
    
        
    </head>
    <body>
        <div class="container-fluid">
  
                        <!--Top navigation bar-->
            <div class="nav">
                <nav class="navbar navbar-expand-lg ">
                   <a class="navbar-brand" href="#">Medication Leaflet System</a>
                   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                       <span class="navbar-toggler-icon"></span>
                   </button>
                   <div class="collapse navbar-collapse" id="navbarText">
                       <ul class="navbar-nav mr-auto">
                           <li class="nav-item">
                               <a class="nav-link" href="index.php">Dashboard <span class="sr-only">(current)</span></a>
                           </li>
                           <li class="nav-item">
                               <a class="nav-link" href="settings.php">Settings</a>
                           </li>
                           
                       </ul>
                       <div class="username">
                    <a href="settings.php"><?php 
                        
                        echo  "$lastname, $firstname"; ?></a>
            </div>
            <div class="logout-text">
                Logout
            </div>
                       <a href="../../logout.php" class="logout-button"><img src="../../images/logout.png" width="25px" height="25px" alt="Logout"></a>
                        
                     
                   </div>
                </nav>
            </div>
            
            <!--Side navigation bar-->
            <div class="side-nav">
                <div class="sidenav">
                    <a href="#" onclick="showOverview()">Overview</a>
                    <a href="#" onclick="showMed()">Manage Medicine</a>
                    <a href="#" onclick="showUser()">Manage Users</a>
			         <a href="#" onclick="showPharms()">Manage Pharmacies</a>
                    <a href="#" onclick="showLicense()">Confirm License</a>
                </div>
            </div>
            <div class="main" style="overflow-y:scroll;">
                
                
                
                
                <!----Overview-->
                <div id="hiddenOverview" class="datEntryOverview">
                    <!--Start table--->
                    <table class="table table-hover medTable hiddenOverview table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                               
                                <th>Time</th>
                                <th>User ID</th>
                                <th>Title</th>
                                <th>Requested By</th>
                            </tr>
                        </thead>
                       
                              <tbody>
                          <tr>
                              <?php while($row = mysqli_fetch_assoc($overview)) : ?>
                              
                              <td><?php echo $row['created'];?></td>
                              <td><?php echo $row['user_id'];?></td>
                              <td><?php echo $row['reason'];?></td>
                              <td><?php echo $row['requested_by'];?></td>
                              
                              
                              <td>
                                  <a href="#"><i class="far fa-edit"></i>View</a>
                                   
                              </td>
                            </tr>
                        </tbody>
                        <?php endwhile; ?>
                            
                            
                              
                              
                              
                                    </table>
                      
                </div>
    
                                <!-----Manage License--->
                <div class="manageLicense hidden" id="hiddenLicense">
                    <table class="table table-hover table-striped table-bordered nowrap">
                        <thead>
                          <tr>
                              <th scope="col">Date</th>
                              <th scope="col">User ID</th>
                              <th scope="col">Path</th>
                              <th colspan="2" scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <?php while($row = mysqli_fetch_assoc($license)) : ?>
                            
                              <th scope="row"><?php echo $row['created'];?></th>
                              <td><?php echo $row['user_id'];?></td>
                              <td><?php echo $row['file'];?></td>
                             
                              <td>
                                  <a href="https://ilesonline.idfpr.illinois.gov/DFPR/Lookup/LicenseLookup.aspx"> Verify</a>  
                                  <a href="index.php?action=deny&user_id=<?php echo $row['user_id'];?>">Deny</a>
                              </td>
                              
                            </tr>
                        </tbody>
                        <?php endwhile; ?>
                                    </table>
                    
                </div>
                
                <!-----Manage UserAccounts--->
                <div class="manageUser hidden" id="hiddenUser">
                    <input type="text" id="myInput" onkeyup="searchUser()" placeholder="Search" style="width:100%;">
                    <table class="table table-hover table-striped table-bordered nowrap" id="user">
                        <thead>
                          <tr>
                              
                              <th scope="col">ID</th>
                              <th scope="col">Username</th>
                              <th scope="col">Status</th>
                              <th scope="col">Type</th>
                              <th colspan="2" scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <?php while($row = mysqli_fetch_assoc($userAccounts)) : ?>
                              <?php if ($row['userType'] == 1){
                                    $type = "User";
                                } else if ($row['userType'] == 2){
                                    $type = "Administrator";
                                } else if ($row['userType'] == 3) {
                                    $type = "Data Entry";
                                } else {
                                    $type = "Invalid";
                                }
                              ?>
                               <?php if ($row['status'] == 1){
                                    $status = "Pending";
                                } else if ($row['status'] == 2){
                                    $status = "Active";
                                } else if ($row['status'] == 3) {
                                    $status = "Banned";
                                } else {
                                    $status = "Invalid";
                                }
                              ?>
                              
                              <td><?php echo $row['userAcc_id'];?></td>
                              <td><?php echo $row['userName'];?></td>
                              <td><?php echo $status;?></td>
                              <td><?php echo $type;?></td>
                              <td>
                                  <!--- <a href="index.php?action=viewUser&userAcc_id=<?php echo $row['userAcc_id'];?>"] id="view-user-detail">View User Details</a>  --->
                                  
                                  <button type="button" class="btn admin-button" data-toggle="modal" data-target="#myModal" id="<?php echo $row['userAcc_id'];?>" onclick="showUserDetails(this);">View Details</button>
                                
                               
                                  
                                 
                                  
                                  <a href="#" id="block-button">Block</a>
                                  <!----
                                  <a href="index.php?action=block&userAcc_id=<?php echo $row['userAcc_id'];?>"> Block</a>
                                  !-->
                                  
                              </td>
                            </tr>
                        </tbody>
                        <?php endwhile; ?>
                                    </table>
                    
                </div>
                    
                    <!------Manage Medicine------>
                   
                <div class="manageMedicine hidden" id="hiddenMedicine">
                    <input type="text" id="medInput" onkeyup="searchMed()" placeholder="Search" style="width:100%;">
                   
                    <table class="table table-hover table-striped table-bordered nowrap medicine-table" id="med">
                        <thead>
                          <tr>
                              <th scope="col">ID</th>
                              <th scope="col">Name</th>
                              <th scope="col">Generic Name</th>
                             
                              <th colspan="2" scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <?php while($row = mysqli_fetch_assoc($medicine)) : ?>
                              <td><?php echo $row['med_id'];?></td>
                              <td><?php echo $row['med_name'];?></td>
                              <td><?php echo $row['general_name'];?></td>
                              
                              <td>
                                  <a href="#"><i class="far fa-edit"></i>Edit</a>
                                  <a href="index.php?action=delete&med_id=<?php echo $row['userAcc_id'];?>"><i class="fas fa-trash-alt"></i>Ban</a>    
                              </td>
                            </tr>
                        </tbody>
                        <?php endwhile; ?>
                                    </table>
                    
                </div>
 <!-----Manage Pharmacies--->
                <div class="managePharmacies hidden" id="hiddenPharmacies">
                    <button id="add_pharm" type="button" class="button" >Add Pharmacy</button>
                    <table class="table table-hover table-striped table-bordered nowrap">
                        <thead>
                          <tr>
                              <th scope="col">Pharmacy ID</th>
                              <th scope="col">Name</th>
                              <th scope="col">Address</th>
                              <th scope="col">City</th>
                              <th scope="col">State</th>
				<th scope="col">Zip</th>
                              <th colspan="2" scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <?php while($row = mysqli_fetch_assoc($pharmacies)) : ?>
                            
                              <th scope="row"><?php echo $row['pharm_id'];?></th>
                              <td><?php echo $row['pharm_name'];?></td>
                              <td><?php echo $row['pharm_address'];?></td>
				<td><?php echo $row['pharm_city'];?></td>
				<td><?php echo $row['pharm_state'];?></td>
				<td><?php echo $row['pharm_zip'];?></td>
                             
                              <td>
                                  <a href="index.php?action=delete&pharm_id=<?php echo $row['pharm_id'];?>">Remove</a>    
                              </td>
                            </tr>
                        </tbody>
                        <?php endwhile; ?>
                                    </table>
                    
                </div>
                    
                    
<div class="block-modal" style="display: none">
                        <div class="block-modal-content">
                            <div class="close">X</div>
                            <form class="block-form" method="post" action="">
                                <p>User: <?php echo "Hi" ?><br>
                                Reason for block:<br></p> 
                                <textarea name="block_reason" rows="5" cols="25"></textarea><br>
                                <input type="submit">
                            </form>
                        </div>
                    </div>
            
                  <!-- View User Detail Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
         
          <h4 class="modal-title">User: <span id="viewuserName"></span></h4>
        </div>
        <div class="modal-body">
         
          User ID: <span id="viewuserID"></span><br>
            First Name: <span id="viewfname"></span><br>
            Last Name: <span id="viewlname"></span><br>
           
            Account Type: <span id="viewType"></span><br>
            Status: <span id="viewstatus"></span><br>
            Address: <span id="viewaddress"></span><br>
            City: <span id="viewcity"></span><br>
            State: <span id="viewstate"></span><br>
            Zip: <span id="viewzip"></span><br>
            Created:<span id="viewcreated"></span><br>
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
           

                <div class="viewMedicineDetails">
                    <?php 
                    if(isset($_GET['action'])){
                        if ($_GET['action'] == 'viewMedDetail'){ 
                    //echo "$medicineHead <br> $medicineResult";
                            ?>Medicine ID: <?php echo $med_id ?><br>
                            National Drug Code: <?php echo $ndc?><br>
                                Medicine Name: <?php echo $medName ?><br>
                                General Name: <?php echo $genName ?><br>
                                Manufacturer: <?php echo $manufac ?><br>
                                Purpose: <?php echo $purpose ?><br>
                                Reactions: <?php echo $reactions ?><br>
                                Warnings: <?php echo $warnings; }}?>
                                
                               
                    
                   
                    
                </div>

                <div class="add-pharmacy-modal" style="display:none">
                   <div class="add-pharmacy-contents">
                    
                <div class="closePharmForm">X</div>
		

                <form action="" method="post">
                    <h3>Add Pharmacy</h3>
                    <input type="text" name="pharmName" placeholder="Pharmacy Name">
                    <input type="text" name="pharmAddress" placeholder="Address">
                    <input type="text" name="pharmCity" placeholder="City">
                    <select name="pharmState">
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                    </select>
                    <input type="text" name="pharmZip" placeholder="ZIP">
                    <input type="tel" name="pharmNumber" placeholder="Phone Number">
                    <input type="submit" name="submitPharm" value="Submit">
                </form>
                       

	</div>
</div>
                </div>
                </div>
           
    
        <script type="text/javascript">
            var user = document.getElementById("hiddenUser");
            var med = document.getElementById("hiddenMedicine");
            var overview = document.getElementById("hiddenOverview");
            var pharm = document.getElementById("hiddenPharmacies");
            var medform = document.getElementById("add-med-form");
            var license = document.getElementById("hiddenLicense");
            
            document.getElementById('block-button').addEventListener('click', function() {
    document.querySelector('.block-modal').style.display = "flex";
});
            document.getElementById('add_pharm').addEventListener("click", function() {
	document.querySelector('.add-pharmacy-modal').style.display = "flex";
});
     
             document.getElementById('view-user-detail').addEventListener("click", function() {
	document.querySelector('.view-user-modal').style.display = "flex";
});
     
            document.querySelector('.close').addEventListener('click', function(){
                document.querySelector('.block-modal').style.display = "none";
            });
            
            document.querySelector('.closePharmForm').addEventListener('click', function(){
                document.querySelector('.add-pharmacy-modal').style.display = "none";
            });
            
            document.querySelector('.closeViewUser').addEventListener('click', function(){
                document.querySelector('.view-user-modal').style.display = "none";
            });
            
            
            
            
            function showMed() {
                
                
                if (med.style.display === "none") {
                    med.style.display = "block";
                    user.style.display = "none";
                    overview.style.display = "none";
                    pharm.style.display = "none";
                    medform.style.display = "none";
                    license.style.display = "none";
                } else {
                med.style.display = "none";
                }
            }
            
            function showUser() {
            
                if (user.style.display === "none") {
                    user.style.display = "block";
                    med.style.display = "none";
                    overview.style.display = "none";
                    pharm.style.display = "none";
                    medform.style.display = "none";
                    license.style.display = "none";
                } else {
                user.style.display = "none";
                }
                
            }
            
            function showPharms() {
            
                if (pharm.style.display === "none") {
                    pharm.style.display = "block";
                    med.style.display = "none";
                    overview.style.display = "none";
                    user.style.display = "none";
                    medform.style.display = "none";
                    license.style.display = "none";
                } else {
                pharm.style.display = "none";
                }
                
            }
            
            function showOverview() {
                
                if (overview.style.display === "none") {
                    overview.style.display = "block";
                    med.style.display = "none";
                    user.style.display = "none";
                    pharm.style.display = "none";
                    medform.style.display = "none";
                    license.style.display = "none";
                } else {
                overview.style.display = "none";
                }
            }
            
        
            function showLicense() {
                
                if (license.style.display === "none") {
                    license.style.display = "block";
                    overview.style.display = "none";
                    med.style.display = "none";
                    user.style.display = "none";
                    pharm.style.display = "none";
                    medform.style.display = "none";
                    
                } else {
                license.style.display = "none";
                }
            }
            
            
            function showMedForm() {
                
                if (medform.style.display === "none") {
                    medform.style.display = "block";
                } else {
                medform.style.display = "none";
                }
            }
            
 

            
        </script>

                   <script>
            function showUserDetails(button){
                var selectedUserID = button.id;
                
                $.ajax({
                    url: "viewUser.php",
                        method: "GET",
                            data: {"userAcc_id": selectedUserID},
                                success: function(response){
                                    // alert(response);
                                    var user = JSON.parse(response);
                                    $("#viewuserID").text(user.userAcc_id);
                                    $("#viewuserName").text(user.userName);
                                    $("#viewfname").text(user.first_name);
                                    $("#viewlname").text(user.last_name);
                                    $("#viewType").text(user.userType);
                                    $("#viewstatus").text(user.status);
                                    $("#viewaddress").text(user.address1+' ' +user.address2);
                                    $("#viewcity").text(user.city);
                                    $("#viewstate").text(user.state);
                                    $("#viewzip").text(user.zip);
                                    $("#viewcreated").text(user.created);
                                }
                });
                
            }
        </script>
            
        <script>
function searchUser() {
  // Declare variables 
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("user");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
        
        <script>
function searchMed() {
  // Declare variables 
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("medInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("med");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
    </body>
</html>

