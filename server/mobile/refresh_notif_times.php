<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$userid = $_POST["userID"];
$notifid = $_POST["notifID"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('
SELECT UMN.notif_time1, UMN.notif_time2, UMN.notif_time3, UMN.notif_time4, UMN.notif_time5, UMN.day_flag, UMN.userMed_amount
FROM UserMedNotif AS UMN
WHERE UMN.userAcc_id = ? AND UMN.notif_id = ?
');
$searchKeyword = $q . '%';
$stmt->bind_param('ii', $userid, $notifid);
$stmt->execute();

$result = $stmt->get_result();

$id_arr = array();

while($row = $result->fetch_row()) {
  $id_arr[] = $row[0] . $row[5];
  $id_arr[] = $row[1] . $row[5];
  $id_arr[] = $row[2] . $row[5];
  $id_arr[] = $row[3] . $row[5];
  $id_arr[] = $row[4] . $row[5];
}

echo json_encode($id_arr);

mysqli_close($conn);

?>