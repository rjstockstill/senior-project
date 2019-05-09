<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$loginUsername = $_POST["loginUsername"];
$loginPass = $_POST["loginPass"];

$hashedPass = hash('sha512', $loginPass);

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('SELECT U.userName, U.userAcc_id FROM UserAccount as U WHERE U.userName = ? AND U.userPass = ?');
$stmt->bind_param('ss', $loginUsername, $hashedPass);
$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_row()) {
  echo "<p id='userAccNum' style='color:transparent;'>$row[1]</p>";
}

mysqli_close($conn);

?>