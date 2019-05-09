<?php include '../../db.php'; 
    session_start();
    

?>

<?php


 $userAcc_id = $_GET['userAcc_id'];
    $query = "SELECT userAcc_id, userName, first_name, last_name, userType, status, city, state, zip, address1, address2, dob, created FROM UserAccount WHERE userAcc_id = 1";
    $result = mysqli_query($connection, $query);

    $user = mysqli_fetch_object($result);
    echo json_encode($user);


?>

