<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$userid = $_POST["userID"];
$medid = $_POST["medID"];
$amount = $_POST["amount"];
$notiftimes = json_decode($_POST["notiftimes"]);
$dayflag = $_POST["dayflag"];

if($notiftimes[0] == " ") {
  $notiftimes[0] = null;
}
if($notiftimes[1] == " ") {
  $notiftimes[1] = null;
}
if($notiftimes[2] == " ") {
  $notiftimes[2] = null;
}
if($notiftimes[3] == " ") {
  $notiftimes[3] = null;
}
if($notiftimes[4] == " ") {
  $notiftimes[4] = null;
}

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare("INSERT INTO UserMedNotif VALUES (0,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param('iiissssss', $userid, $medid, $amount, $notiftimes[0], $notiftimes[1], $notiftimes[2], $notiftimes[3], $notiftimes[4], $dayflag);

if($stmt->execute()) {
  $stmt2 = $conn->prepare('INSERT INTO UserMeds VALUES (?,?,1) ON DUPLICATE KEY UPDATE notif_set = 1');
  $stmt2->bind_param('ii', $userid, $medid);
  if($stmt2->execute()) {
    echo "success";
  }
}
else {
  echo "failure";
}

mysqli_close($conn);

?>