<?php 
    
    include '../../db.php'; 
    session_start();

?>

<?php

    if (isset($_POST['fromMonth'])){
        $fromMonth = mysqli_real_escape_string($connection, $_POST['fromMonth']);
    }
    if (isset($_POST['fromDay'])){
        $fromDay = mysqli_real_escape_string($connection, $_POST['fromDay']);
    }
    if (isset($_POST['fromYear'])){
        $fromYear = mysqli_real_escape_string($connection, $_POST['fromYear']);
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
      
      
      /*  
        switch ($reportType) {
                
            case "Users":
                $query = "SELECT * From UserAccount WHERE created >= ? AND created < ?";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("ss", $from, $to);
                $stmt -> execute();
                
                
                 if ($stmt->execute()) { 
                $stmt->close();
                } else { 
                    header("Location: index.php?success=user%20%status%20updated");
                 }

                break;
                
            case "Medicine": 
                $query = "SELECT * From Medicine";
                break;
            case "Pharmacies":
                $query = "SELECT * From Pharmacies";
                break;
            case "Reviews":
                $query = "SELECT * FROM Reviews";
        }
        */

        if($reportType == "Users"){
            
            
            $namequery = $connection -> prepare("SELECT userAcc_id, userName, first_name, last_name, created FROM UserAccount WHERE created < ? AND created > ?");
            $namequery -> bind_param("ss", $toDate, $fromDate);
            $namequery -> execute();
            $namequery->store_result();

            if($namequery->num_rows>0){
                $namequery->bind_result($userAcc_id, $userName, $first_name, $last_name, $created);
                while($namequery->fetch()){
                   // echo $userAcc_id, $userName, $first_name, // $last_name, $created;
                    
                    $_SESSION['userID'] = $userAcc_id;
                    $_SESSION['userName'] = $userName;
                    
                    //echo $_SESSION['userID'];
                    header("location: reportForm.php?success=Generated%20Table");
                }
                
                $namequery->close();


            }   else{
                echo "Couldn't find that row...";
                 }

        }

        if($reportType == "Medicines"){
            
            
            $namequery = $connection -> prepare("SELECT userAcc_id, userName, first_name, last_name, created FROM UserAccount WHERE created < ? AND created > ?");
            $namequery -> bind_param("ss", $toDate, $fromDate);
            $namequery -> execute();
            $namequery->store_result();

            if($namequery->num_rows>0){
                $namequery->bind_result($userAcc_id, $userName, $first_name, $last_name, $created);
                while($namequery->fetch()){
                    echo $userAcc_id, $userName, $first_name, $last_name, $created;
                }
                
                $namequery->close();

                

            }   else{
                echo "Couldn't find that row...";
                 }

        }
        
        if($reportType == "Pharmacies"){
            
            
            $namequery = $connection -> prepare("SELECT userAcc_id, userName, first_name, last_name, created FROM UserAccount WHERE created < ? AND created > ?");
            $namequery -> bind_param("ss", $toDate, $fromDate);
            $namequery -> execute();
            $namequery->store_result();

            if($namequery->num_rows>0){
                $namequery->bind_result($userAcc_id, $userName, $first_name, $last_name, $created);
                while($namequery->fetch()){
                    echo $userAcc_id, $userName, $first_name, $last_name, $created;
                }
                
                $namequery->close();

                

            }   else{
                echo "Couldn't find that row...";
                 }

        }
 
        if($reportType == "Review"){
            
            
            $namequery = $connection -> prepare("SELECT userAcc_id, userName, first_name, last_name, created FROM UserAccount WHERE created < ? AND created > ?");
            $namequery -> bind_param("ss", $toDate, $fromDate);
            $namequery -> execute();
            $namequery->store_result();

            if($namequery->num_rows>0){
                $namequery->bind_result($userAcc_id, $userName, $first_name, $last_name, $created);
                while($namequery->fetch()){
                    echo $userAcc_id, $userName, $first_name, $last_name, $created;
                }
                
                $namequery->close();

                

            }   else{
                echo "Couldn't find that row...";
                 }

        }
        
        
    
        
      ?>  
        
  