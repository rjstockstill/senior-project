<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$q = $_POST["userSearchbar"];
$userID = $_POST["userID"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('
SELECT userAcc_id, userName 
FROM UserAccount 
WHERE (userName LIKE ?) 
AND (userName <> (SELECT userName FROM UserAccount WHERE userAcc_id = ?)) 
AND (NOT EXISTS(SELECT * FROM Friends WHERE ((sender = ? AND receiver = userAcc_id) OR (sender = userAcc_id AND receiver = ?)) 
AND (accepted = 1 OR accepted = 2)))
');
$searchKeyword = $q . '%';
$stmt->bind_param('siii', $searchKeyword, $userID, $userID, $userID);
$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_row()) {
  echo "<div class='card cardshadow' style='margin-bottom:10px;'>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class='col'>";
  echo "<h4 class='card-title'>$row[1]</h4>";
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px;'>Add this user</h6>";
  echo "</div>";
  echo "<div class='col my-auto' style='text-align:right; font-size:20px;'>";
  echo "<i class='fas fa-user-plus' style='display:inline;' onclick='addFriend(\"$row[0]\", \"$row[1]\")'></i>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}
echo "<hr />";


mysqli_close($conn);

?>