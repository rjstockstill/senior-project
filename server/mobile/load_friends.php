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

$stmt = $conn->prepare('
SELECT userAcc_id, userName 
FROM UserAccount 
WHERE EXISTS(SELECT * FROM Friends WHERE ((sender = ? AND receiver = userAcc_id) OR (sender = userAcc_id AND receiver = ?)) AND (accepted = 2))
');
$searchKeyword = $q . '%';
$stmt->bind_param('ii', $userID, $userID);
$stmt->execute();

$result = $stmt->get_result();

echo "<h3>Friends</h3>";
echo "<br />";
if(mysqli_num_rows($result) == 0) {
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px; font-style:italic;'>There's nothing here yet.</h6>";
}
while($row = $result->fetch_row()) {
  echo "<div class='card cardshadow' style='margin-bottom:10px;'>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class='col'>";
  echo "<h4 class='card-title'>$row[1]</h4>";
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px;'>Friend</h6>";
  echo "</div>";
  echo "<div class='col my-auto' style='text-align:right; font-size:20px;'>";
  echo "<i class='fas fa-user-minus' style='display:inline; color:red;' onclick='removeFriend(\"$row[0]\", \"$row[1]\")'></i>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}
echo "<hr />";


$stmt = $conn->prepare('
SELECT UMN.userAcc_id, UMN.med_id, U.userName, M.med_name, UMN.userMed_amount, UMN.notif_time1, UMN.notif_time2, UMN.notif_time3, UMN.notif_time4, UMN.notif_time5, UMN.day_flag
FROM UserMedNotif AS UMN, Friends AS F, UserAccount AS U, Medicine AS M
WHERE (F.sender = ? OR F.receiver = ?) AND F.accepted = 2 AND U.userAcc_id = UMN.userAcc_id AND UMN.userAcc_id <> ? AND UMN.med_id = M.med_id AND NOT EXISTS(SELECT userAcc_id, med_id FROM GroupMedNotif, Friends as F WHERE userAcc_id = F.sender OR userAcc_id = F.receiver)
');
$searchKeyword = $q . '%';
$stmt->bind_param('iii', $userID, $userID, $userID);
$stmt->execute();

$result = $stmt->get_result();

echo "<h3>Group Notifications</h3>";
echo "<br />";

while($row = $result->fetch_row()) {
  echo "<div class='card cardshadow' style='margin-bottom:10px;'>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class='col'>";
  echo "<h4 class='card-title'>$row[2]</h4>";
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px;'>Has a reminder for $row[3]</h6>";
  echo "</div>";
  echo "<div class='col my-auto' style='text-align:right; font-size:20px;'>";
  echo "<i class='fas fa-bell' style='display:inline; color:#9068be;' onclick='addToGroupNotifications($row[0], $row[1], $row[4], \"$row[5]\", \"$row[6]\", \"$row[7]\", \"$row[8]\", \"$row[9]\", \"$row[10]\")'></i>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}


$stmt = $conn->prepare('
SELECT GMN.userAcc_id, GMN.med_id, U.userName, M.med_name
FROM Friends AS F, UserAccount AS U, Medicine AS M, GroupMedNotif as GMN
WHERE (F.sender = ? OR F.receiver = ?) AND F.accepted = 2 AND U.userAcc_id = GMN.userAcc_id AND GMN.userAcc_id <> ? AND GMN.med_id = M.med_id AND GMN.notif_enabled = 1
');
$searchKeyword = $q . '%';
$stmt->bind_param('iii', $userID, $userID, $userID);
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
  echo "<h4 class='card-title'>$row[2]</h4>";
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px;'>Reminder set for $row[3]</h6>";
  echo "</div>";
  echo "<div class='col my-auto' style='text-align:right; font-size:20px;'>";
  echo "<i class='fas fa-bell-slash' style='display:inline; color:#9068be;' onclick='removeFromGroupNotifications($row[0], $row[1])'></i>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}


echo "<hr />";


mysqli_close($conn);

?>