<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$userID = $_POST["userID"];
$friendID = $_POST["friendID"];
$userName = $_POST["userName"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('
SELECT C.sender, C.content, C.created
FROM ChatMessage AS C
WHERE ((C.sender = ?) AND (C.receiver = ?)) OR ((C.receiver = ?) AND (C.sender = ?))
ORDER BY C.created ASC
');
$searchKeyword = $q . '%';
$stmt->bind_param('iiii', $userID, $friendID, $userID, $friendID);
$stmt->execute();

$result = $stmt->get_result();

if(mysqli_num_rows($result) == 0) {
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px; font-style:italic;'>You have not sent any messages yet.</h6>";
}
while($row = $result->fetch_row()) {

$sub_stmt = $conn->prepare('SELECT userAcc_id, userName FROM UserAccount WHERE userAcc_id = ?');
$sub_stmt->bind_param('i', $userID);
$sub_stmt->execute();
$sub_result = $sub_stmt->get_result();
while($sub_row = $sub_result->fetch_row()) {
if($row[0] == $userID) {
echo
"
<div style='padding-left:15px; padding-right:15px;'>
<div class='row'>

<div class='col-4'>
<div></div>
</div>

<div class='col-8'>
<p class='text-muted' style='margin-bottom:0; margin-left:10px; font-size:12px;'>$sub_row[1]</p>
<div style='min-height:15px; line-height:15px; background-color:skyblue; padding:10px; margin-bottom:10px; border-radius:20px;'>
<p style='vertical-align:middle; line-height:normal; margin-left:6px; color:white;'>$row[1]</p>
</div>
</div>

</div>
</div>
";

} else {
$friendname = "";
$sub_stmt = $conn->prepare('SELECT userAcc_id, userName FROM UserAccount WHERE userAcc_id = ?');
$sub_stmt->bind_param('i', $friendID);
$sub_stmt->execute();
$sub_result = $sub_stmt->get_result();
while($sub_row = $sub_result->fetch_row()) {
  $friendname = $sub_row[1];
}
echo
"
<div style='padding-left:15px; padding-right:15px;'>
<div class='row'>

<div class='col-8'>
<p class='text-muted' style='margin-bottom:0; margin-left:10px; font-size:12px;'>$friendname</p>
<div style='min-height:15px; line-height:15px; background-color:gainsboro; padding:10px; margin-bottom:10px; border-radius:20px;'>
<p style='display:inline-block; vertical-align:middle; line-height:normal; margin-left:6px;'>$row[1]</p>
</div>
</div>

<div class='col-4'>
</div>

</div>
</div>
";

}
break;
}

}


mysqli_close($conn);

?>