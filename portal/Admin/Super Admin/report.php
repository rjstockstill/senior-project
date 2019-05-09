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

<?
if (isset($_POST['submit'])){
    if (isset($_POST['fromDay'])){
        $fromDay = mysqli_real_escape_string($connection, $_POST['fromDay']);
    }
    if (isset($_POST['fromYear'])){
        $fromYear = mysqli_real_escape_string($connection, $_POST['fromYear']);
    }
    
    if (isset($_POST['fromMonth'])){
        $fromMonth = mysqli_real_escape_string($connection, $_POST['fromMonth']);
    }
    
    if (isset($_POST['toMonth'])){
        $toMonth = mysqli_real_escape_string($connection, $_POST['toMonth']);
    }
    if (isset($_POST['toDay'])){
        $toDay = mysqli_real_escape_string($connection, $_POST['toDay']);
    }
    if (isset($_POST['toYear'])){
        $toYear = mysqli_real_escape_string($connection, $_POST['toYear']);
    }


    if (isset($_POST['reportType'])){
        $reportType = mysqli_real_escape_string($connection, $_POST['reportType']);
    }
    if (isset($_POST['count'])){
        $count = mysqli_real_escape_string($connection, $_POST['count']);
    }
    if (isset($_POST['allData'])){
        $allData = mysqli_real_escape_string($connection, $_POST['allData']);
    }

        
        $from = $fromYear .'-'. $fromMonth .'-'. $fromDay . ' 00:00:00';
        $fromDate = date("Y-m-d H:i:s",strtotime($from));
        $to = $toYear .'-'. $toMonth .'-'. $toDay . ' 00:00:00';
        $toDate = date("Y-m-d H:i:s",strtotime($to));
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="../style.css" type="text/css">
        
       
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <title>Gather Reports | MLS</title>
        
    </head>
    <body>
        <div class="container">
            <!-------Navigation Bar----------->
                <div class="nav">
                    <div class="navbar-text">
                        <a href="index.php">Super Administrator</a>
                    </div>
                    <div class="username">
                        <?php echo "$lastname, $firstname"; ?>
                    </div>
                    <div class="logout-text">
                        Logout
                    </div>

                    <a href="../../logout.php" class="logout-button"><img src="../../images/logout.png" width="25px" height="25px" alt="Logout"></a>
                </div>
            <div class="header">
                
                <h1>Gather Reports</h1>
                <hr>
            </div>
            
            <div class="left-reports">

                <form method="post" action="" class="reportForm">
                    
                    
                    <div class="form-row">
                        <label>From</label><br>
                        <div class="">
                            <select name="fromMonth" id="fromMonth" class="form-control">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April<option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>  
                            </select>
                    </div>


                        <div class="form-group col-md-2">
                            <select name= "fromDay" id="fromDay" class="form-control">
                                <option value="01">1</option>       
                                <option value="02">2</option>       
                                <option value="03">3</option>       
                                <option value="04">4</option>       
                                <option value="05">5</option>       
                                <option value="06">6</option>      
                                <option value="07">7</option>       
                                <option value="08">8</option>       
                                <option value="09">9</option>       
                                <option value="10">10</option>       
                                <option value="11">11</option>       
                                <option value="12">12</option>       
                                <option value="13">13</option>       
                                <option value="14">14</option>       
                                <option value="15">15</option>       
                                <option value="16">16</option>       
                                <option value="17">17</option>       
                                <option value="18">18</option>       
                                <option value="19">19</option>       
                                <option value="20">20</option>       
                                <option value="21">21</option>       
                                <option value="22">22</option>       
                                <option value="23">23</option>       
                                <option value="24">24</option>       
                                <option value="25">25</option>       
                                <option value="26">26</option>       
                                <option value="27">27</option>       
                                <option value="28">28</option>       
                                <option value="29">29</option>       
                                <option value="30">30</option>       
                                <option value="31">31</option>  
                            </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select name="fromYear" class="form-control" id="fromYear"> 
                                <option value="2019">2019</option>
                                <option value="2018">2018</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <label>To</label><br>
                        <div class="form-group col-md-3">
                            <select id="toMonth" name="toMonth" class="form-control">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April<option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>  
                            </select>
                    </div>


                        <div class="form-group col-md-2">
                            <select name= "toDay" id="toDay" class="form-control">
                                <option value="01">1</option>       
                                <option value="02">2</option>       
                                <option value="03">3</option>       
                                <option value="04">4</option>       
                                <option value="05">5</option>       
                                <option value="06">6</option>      
                                <option value="07">7</option>       
                                <option value="08">8</option>       
                                <option value="09">9</option>       
                                <option value="10">10</option>       
                                <option value="11">11</option>       
                                <option value="12">12</option>       
                                <option value="13">13</option>       
                                <option value="14">14</option>       
                                <option value="15">15</option>       
                                <option value="16">16</option>       
                                <option value="17">17</option>       
                                <option value="18">18</option>       
                                <option value="19">19</option>       
                                <option value="20">20</option>       
                                <option value="21">21</option>       
                                <option value="22">22</option>       
                                <option value="23">23</option>       
                                <option value="24">24</option>       
                                <option value="25">25</option>       
                                <option value="26">26</option>       
                                <option value="27">27</option>       
                                <option value="28">28</option>       
                                <option value="29">29</option>       
                                <option value="30">30</option>       
                                <option value="31">31</option>  
                            </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select name="toYear" class="form-control" id="toYear"> 
                                <option value="2019">2019</option>
                                <option value="2018">2018</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-row row3">
                        <div class="form-group col-md-3">
                            <label>Type</label><br>
                            <select name="reportType" class="form-control" id=reportType> 
                                <option value="Users">Users</option>
                                <option value="Medicine">Medicines</option>
                                <option value="Pharmacies">Pharmacies</option>
                            </select>
                            
                                <label class="checkbox">
                                    <input type="checkbox" value="count" name="count">Include Count
                                </label>
                                
                            </div>
                        
                            
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <input type="reset" value="Clear Fields" class="clearReportButton">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="submit" name="submit" id="reports" value="Generate Report" class="submitReportButton">
                        </div>
                    </div>
                    </form>
                </div>
           
        
        <div class="right-reports" id="reports" style="overflow-y:scroll;"> 

            <?php 
                if(isset($_POST['submit'])){
                    if($reportType == "Users"){
            
            
                        $userAccountQuery = $connection -> prepare("SELECT userAcc_id, userName, first_name, last_name, created FROM UserAccount WHERE created < ? AND created > ?");
                        $userAccountQuery -> bind_param("ss", $toDate, $fromDate);
                        $userAccountQuery -> execute();
                        $userAccountQuery->store_result();

                        if($userAccountQuery->num_rows>0){
                            $userAccountQuery->bind_result($userAcc_id, $userName, $first_name, $last_name, $created);
                            echo "<table><thead><tr>";
                                echo "<th>User ID</th>
                                      <th>Username</th>
                                      <th>First Name</th>
                                      <th>Last Name</th>
                                      <th>Created</th></tr>";

                            while($userAccountQuery->fetch()){
                                echo "<tr><td>$userAcc_id</td><td>$userName</td><td>$first_name</td><td>$last_name</td><td>$created</td></tr>";
                                

                            }

                            if(isset($_POST['count'])){
                                    $stmt = $connection->prepare("SELECT COUNT(*) FROM UserAccount");
                                    $stmt->execute();
                                    $stmt->bind_result($totalRows);
                                    $stmt->fetch();
                                    echo 'Total number of users: '.$totalRows;
                                    $stmt->close();
                                } else{
                                    
                                }
                                echo "</thead></table";
                            $userAccountQuery->close();
                        }


                           else{
                           echo "Couldn't find that row...";
                            }
                        
                    }   else if($reportType == "Medicine"){
            
            
                        $medicineQuery = $connection -> prepare("SELECT med_id, med_name, general_name, med_manufacturer, med_purpose, med_dosage, med_reactions, med_warnings, med_ndc FROM Medicine");
                       
                        $medicineQuery -> execute();
                        $medicineQuery->store_result();

                        if($medicineQuery->num_rows>0){
                            $medicineQuery->bind_result($med_id, $medName, $genName, $manufac, $purpose, $dosage, $reactions, $warnings, $ndc);
                            echo "<table><thead><tr>";
                                echo "<th>Medicine ID</th>
                                      <th>Medicince Name</th>
                                      <th>General Name</th>
                                      <th>Manufacturer</th>
                                      <th>Purpose</th>
                                      <th>Dosage</th>
                                      <th>Reactions</th>
                                      <th>Warnings</th>
                                      <th>NDC Code</th></tr>";

                            while($medicineQuery->fetch()){
                                echo "<tr><td>$med_id</td><td>$medName</td><td>$genName</td><td>$manufac</td><td>$purpose</td><td>$dosage</td><td>$reactions</td><td>$warnings</td><td>$ndc</td></tr>";
                                

                            }

                            if(isset($_POST['count'])){
                                    $stmt = $connection->prepare("SELECT COUNT(*) FROM Medicine");
                                    $stmt->execute();
                                    $stmt->bind_result($totalRows);
                                    $stmt->fetch();
                                    echo 'Total number of medicine in database: '.$totalRows;
                                    $stmt->close();
                                }
                                echo "</thead></table";
                            $medicineQuery->close();
                        }


                           else{
                           echo "Couldn't find that row...";
                            }
                    }
                 else if($reportType == "Pharmacies"){
            
            
                        $pharmQuery = $connection -> prepare("SELECT * FROM Pharmacies");
                       
                        $pharmQuery -> execute();
                        $pharmQuery->store_result();

                        if($pharmQuery->num_rows>0){
                            $pharmQuery->bind_result($pharm_id, $pharm_name, $pharm_address, $pharm_city, $pharm_state, $pharm_zip, $pharm_num);
                            echo "<table><thead><tr>";
                                echo "<th>Pharmacy ID</th>
                                      <th>Pharmacy Name</th>
                                      <th>Pharmacy Address</th>
                                      <th>City</th>
                                      <th>State</th>
                                      <th>Zip</th>
                                      <th>Number</th></tr>";

                            while($pharmQuery->fetch()){
                                echo "<tr><td>$pharm_id</td><td>$pharm_name</td><td>$pharm_address</td><td>$pharm_city</td><td>$pharm_state</td><td>$pharm_zip</td><td>$pharm_num</td></tr>";

                            }

                            if(isset($_POST['count'])){
                                    $stmt = $connection->prepare("SELECT COUNT(*) FROM Pharmacies");
                                    $stmt->execute();
                                    $stmt->bind_result($totalRows);
                                    $stmt->fetch();
                                    echo 'Total number of pharmacies in database: '.$totalRows;
                                    $stmt->close();
                                } else{
                                    
                                }
                                echo "</thead></table";
                            $pharmQuery->close();
                        }

                          else{
                           echo "Couldn't find that row...";
                            }
                }
}
?>
                    </div>
        </div>
        
    </body>
</html>
