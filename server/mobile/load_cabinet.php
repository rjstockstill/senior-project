<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$userid = $_POST["userID"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('
SELECT U.userAcc_id, M.med_name, M.med_id
FROM Medicine AS M, UserAccount AS U, UserMeds AS UM
WHERE U.userAcc_id = ? AND U.userAcc_id = UM.userAcc_id AND M.med_id = UM.med_id AND UM.notif_set = 0
');
$searchKeyword = $q . '%';
$stmt->bind_param('i', $userid);
$stmt->execute();

$result = $stmt->get_result();

echo "<h3>Added Medicines</h3>";
while($row = $result->fetch_row()) {
  echo "<div class='card cardshadow' style='margin-bottom:10px;'>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class='col'>";
  echo "<h5 class='card-title'>$row[1]</h5>";
  echo "</div>";
  echo "<div class='col my-auto' style='text-align:right; font-size:24px;'>";
  echo "<i class='fas fa-bell' style='display:inline; color:#9068be;' onclick='addToNotifications(\"$row[0]\", \"$row[2]\")'>&nbsp;&nbsp;&nbsp;&nbsp;</i>";
  echo "<i class='far fa-times-circle' style='display:inline; color:red;' onclick='removeFromCabinet(\"$row[0]\", \"$row[2]\")'></i>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}
echo "<hr />";


$stmt = $conn->prepare('
SELECT U.userAcc_id, M.med_name, M.med_id, UMN.day_flag, UMN.notif_time1, UMN.notif_time2, UMN.notif_time3, UMN.notif_time4, UMN.notif_time5
FROM Medicine AS M, UserAccount AS U, UserMeds AS UM, UserMedNotif AS UMN
WHERE U.userAcc_id = ? AND U.userAcc_id = UM.userAcc_id AND M.med_id = UM.med_id AND UM.notif_set = 1 AND UM.med_id = UMN.med_id
');
$searchKeyword = $q . '%';
$stmt->bind_param('i', $userid);
$stmt->execute();

$result = $stmt->get_result();
$week = array("M","T","W","R","F","S","S");

echo "<h3>Notifications</h3>";
while($row = $result->fetch_row()) {
  $daysoftheweek = "";
  $times = substr($row[4], 0, 5);
  for($i = 0; $i < 7; $i++) {
    if($row[3][$i] == 1) {
      $daysoftheweek = $daysoftheweek . $week[$i];
    }
  }

  if(!is_null($row[5])) {
    $times .= ", " . substr($row[5], 0, 5);
  }
  if(!is_null($row[6])) {
    $times .= ", " . substr($row[6], 0, 5);
  }
  if(!is_null($row[7])) {
    $times .= ", " . substr($row[7], 0, 5);
  }
  if(!is_null($row[8])) {
    $times .= ", " . substr($row[8], 0, 5);
  }


  echo "<div class='card cardshadow' style='margin-bottom:10px;'>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class='col'>";
  echo "<h5 class='card-title'>$row[1]</h5>";
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px;'>$daysoftheweek | $times</h6>";
  echo "</div>";
  echo "<div class='col my-auto' style='text-align:right; font-size:24px;'>";
  echo "<i class='fas fa-bell-slash' style='display:inline; color:#9068be;' onclick='removeFromNotifications(\"$row[0]\", \"$row[2]\")'>&nbsp;&nbsp;&nbsp;&nbsp;</i>";
  echo "<i class='far fa-times-circle' style='display:inline; color:red;' onclick='removeFromCabinet(\"$row[0]\", \"$row[2]\")'></i>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}


mysqli_close($conn);

?>