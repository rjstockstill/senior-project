<?php

$servername = "localhost:3306";
$username = "jude";
$password = "sqlpass";
$dbname = "mls_test";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}
#echo "Connected!";

$query = "
SELECT M.med_name, M.general_name, concat(UR.rating, '/5')
FROM Medicine as M, UserReview as UR
WHERE M.med_id = UR.med_id
ORDER BY M.med_name
";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_row($result)) {
  echo "<div class='card' style='margin:15px; padding:0px;'>";
  echo "<div class='card-body'>";
  echo "<h5 class='card-title'>$row[0]</h5>";
  echo "<h6 class='card-subtitle mb-2 text-muted'>$row[1]</h6>";
  echo "<br/>";
  echo "<p class='card-text' style='color:green;'>$row[2]</p>";
  echo "</div>";
  echo "</div>";
}

mysqli_close($conn);

?>













<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$q = $_POST["userSearchbar"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}
#echo "Connected!";

$stmt = $conn->prepare('SELECT U.userName FROM UserAccount AS U, Friends AS F WHERE U.userName LIKE 'John' AND F.accepted <> 1');
$searchKeyword = $q . '%';
$stmt->bind_param('s', $searchKeyword);
$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_row()) {
  echo "<div class='card' style='margin-bottom:10px;'>"
  echo "<div class='card-body'>"
  echo "<div class='row'>"
  echo "<div class='col'>"
  echo "<h4 class='card-title'>$row[0]</h4>"
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px;'>Add this user</h6>"
  echo "</div>"
  echo "<div class='col my-auto' style='text-align:right; font-size:20px;'>"
  echo "<i class='fas fa-user-plus' style='display:inline;' onclick='addFriend(\"$row[0]\")'></i>"
  echo "</div>"
  echo "</div>"
  echo "</div>"
  echo "</div>"
}

mysqli_close($conn);

?>




























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
#echo "Connected!";

$stmt = $conn->prepare('SELECT userName FROM UserAccount WHERE userName LIKE ? AND NOT EXISTS(SELECT * FROM Friends WHERE sender = ? OR receiver = ?)');
$searchKeyword = $q . '%';
$stmt->bind_param('sii', $searchKeyword. $userID, $userID);
$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_row()) {
  echo "<div class='card' style='margin-bottom:10px;'>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class='col'>";
  echo "<h4 class='card-title'>$row[0]</h4>";
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px;'>Add this user</h6>";
  echo "</div>";
  echo "<div class='col my-auto' style='text-align:right; font-size:20px;'>";
  echo "<i class='fas fa-user-plus' style='display:inline;' onclick='addFriend(\"$row[0]\")'></i>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}

mysqli_close($conn);

?>