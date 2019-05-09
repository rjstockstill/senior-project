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
SELECT UMN.notif_id
FROM UserMedNotif AS UMN
WHERE UMN.userAcc_id = ?
');
$searchKeyword = $q . '%';
$stmt->bind_param('i', $userid);
$stmt->execute();

$result = $stmt->get_result();

$id_arr = array();

while($row = $result->fetch_row()) {
  $id_arr[] = $row;
}

echo json_encode($id_arr);

mysqli_close($conn);

?>