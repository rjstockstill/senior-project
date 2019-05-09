<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$userid = $_POST["userID"];
$medid = $_POST["medID"];
$amount = $_POST["amount"];
$time1 = $_POST["time1"];
$time2 = $_POST["time2"];
$time3 = $_POST["time3"];
$time4 = $_POST["time4"];
$time5 = $_POST["time5"];
$dayflag = $_POST["dayflag"];
$notif_enabled = $_POST["notif_enabled"];

if($time1 == "") {
  $time1 = null;
}
if($time2 == "") {
  $time2 = null;
}
if($time3 == "") {
  $time3 = null;
}
if($time4 == "") {
  $time4 = null;
}
if($time5 == "") {
  $time5 = null;
}


$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare("INSERT INTO GroupMedNotif VALUES (0,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param('iiissssssi', $userid, $medid, $amount, $time1, $time2, $time3, $time4, $time5, $dayflag, $notif_enabled);

if($stmt->execute()) {
  echo "success";
}
else {
  echo "failure";
}

mysqli_close($conn);

?>