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
$stmt = $conn->prepare('INSERT INTO UserMeds VALUES (?,?,0)');
$stmt->bind_param('ii', $userid, $medid);
$stmt->execute();

mysqli_close($conn);

?>