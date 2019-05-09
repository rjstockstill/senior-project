<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$senderID = $_POST["senderID"];
$receiverID = $_POST["receiverID"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

# 0 is deleted or removed, 1 is pending, 2 is friends
$stmt = $conn->prepare('DELETE FROM Friends WHERE ((sender = ?) AND (receiver = ?)) OR ((sender = ?) AND (receiver = ?))');
$stmt->bind_param('iiii', $senderID, $receiverID, $receiverID, $senderID);
$stmt->execute();


mysqli_close($conn);

?>