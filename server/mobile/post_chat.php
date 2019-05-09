<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$userID = $_POST["userID"];
$friendID = $_POST["friendID"];
$comment = $_POST["comment"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('INSERT INTO ChatMessage VALUES (0,?,?,NOW(),?)');
$stmt->bind_param('iis', $userID, $friendID, $comment);
$stmt->execute();


mysqli_close($conn);

?>