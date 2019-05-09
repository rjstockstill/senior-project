<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$userid = $_POST["userID"];
$medid = $_POST["medID"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

# 0 is no notifs, 1 is notifs
$stmt = $conn->prepare('DELETE FROM UserMeds WHERE userAcc_id = ? AND med_id = ?');
$stmt->bind_param('ii', $userid, $medid);
$stmt->execute();

$stmt = $conn->prepare('DELETE FROM UserMedNotif WHERE userAcc_id = ? AND med_id = ?');
$stmt->bind_param('ii', $userid, $medid);
$stmt->execute();


mysqli_close($conn);

?>