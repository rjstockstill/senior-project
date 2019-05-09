<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$userid = $_POST["userID"];
$reviewid = $_POST["reviewID"];
$comment = $_POST["comment"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('INSERT INTO ReviewReply VALUES (0,?,?,NOW(),?,0,0,0)');
$stmt->bind_param('iis', $userid, $reviewid, $comment);
$stmt->execute();


mysqli_close($conn);

?>