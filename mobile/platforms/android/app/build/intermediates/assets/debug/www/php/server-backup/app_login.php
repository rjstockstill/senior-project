<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$loginUsername = $_POST["loginUsername"];
$loginPass = $_POST["loginPass"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}
#echo "Connected!";

$stmt = $conn->prepare('SELECT U.userName, U.userAcc_id FROM UserAccount as U WHERE U.userName = ? AND U.userPass = ?');
$stmt->bind_param('ss', $loginUsername, $loginPass);
$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_row()) {
  echo "<h2 class='card-title appcardheader boldfont'>Hi, $row[0]</h2>";
  echo "<p class='card-text appcardtext'>You have 3 prescriptions to take today.</p>";
  echo "<p id='userAccNum' style='color:transparent;'>$row[1]</p>";
}

mysqli_close($conn);

?>