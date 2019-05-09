<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$registerUsername = $_POST["registerUsername"];
$registerPass = $_POST["registerPass"];
$registerFirstname = $_POST["registerFirstname"];
$registerLastname = $_POST["registerLastname"];
$registerAddress = $_POST["registerAddress"];
$registerCity = $_POST["registerCity"];
$registerState = $_POST["registerState"];

$hashedPass = hash('sha512', $registerPass);

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('INSERT INTO UserAccount VALUES(0,?,?,0,13,37,1,NOW())');
$stmt->bind_param('ss', $registerUsername, $hashedPass);

if($stmt->execute()) { echo "success"; }
else { echo "failure"; }

mysqli_close($conn);

?>