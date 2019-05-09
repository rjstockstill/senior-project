<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$userID = $_POST["userID"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('SELECT userAcc_id, userName FROM UserAccount WHERE EXISTS(SELECT * FROM Friends WHERE ((sender = userAcc_id AND receiver = ?)) AND (accepted = 1))');
$stmt->bind_param('i', $userID);
$stmt->execute();

$result = $stmt->get_result();

echo "<h3>Requests</h3>";
echo "<br />";
while($row = $result->fetch_row()) {
  echo "<div class='card cardshadow' style='margin-bottom:10px;'>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class='col'>";
  echo "<h4 class='card-title'>$row[1]</h4>";
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px;'>Incoming request</h6>";
  echo "</div>";
  echo "<div class='col my-auto' style='text-align:right; font-size:20px;'>";
  echo "<i class='fas fa-user-plus' style='display:inline; color:#9068be;' onclick='approveRequest(\"$row[0]\", \"$row[1]\")'>&nbsp;&nbsp;&nbsp;&nbsp;</i>";
  echo "<i class='fas fa-user-minus' style='display:inline; color:red;' onclick='removeRequest(\"$row[0]\", \"$row[1]\")'></i>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}


$stmt = $conn->prepare('SELECT userAcc_id, userName FROM UserAccount WHERE EXISTS(SELECT * FROM Friends WHERE ((sender = ? AND receiver = userAcc_id)) AND (accepted = 1))');
$searchKeyword = $q . '%';
$stmt->bind_param('i', $userID);
$stmt->execute();

$result2 = $stmt->get_result();
if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0) {
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px; font-style:italic;'>There's nothing here yet.</h6>";
}

while($row = $result2->fetch_row()) {
  echo "<div class='card cardshadow' style='margin-bottom:10px;'>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class='col'>";
  echo "<h4 class='card-title'>$row[1]</h4>";
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px;'>Outgoing request</h6>";
  echo "</div>";
  echo "<div class='col my-auto' style='text-align:right; font-size:20px;'>";
  echo "<i class='fas fa-times' style='display:inline; color:red;' onclick='removeRequest(\"$row[0]\", \"$row[1]\")'></i>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}


mysqli_close($conn);

?>