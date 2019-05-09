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

if(mysqli_num_rows($result) == 0) {
  echo "<h6 class='card-subtitle text-muted' style='font-size:14px; font-style:italic;'>You have no friends to chat with yet.</h6>";
}
while($row = $result->fetch_row()) {
echo "
<div class='card-body' style='padding-top:0; padding-bottom:0;' onclick='openChat(\"$row[0]\", \"$row[1]\")'>
<div class='row'>

<div class='col-2' style='padding-left:20px;'>
<span class='fa-stack fa-2x' style='font-size:26px; position:relative; top:50%; left:50%; transform:translate(-50%,-50%);'>
<i class='fas fa-circle fa-stack-2x' style='color:silver;'></i>
<i class='fas fa-camera fa-stack-1x' style='color:grey;'></i>
</span>
</div>

<div class='col-10' style='padding-left:16px;'>
<h4 class='card-title' style='font-size:18px; margin-bottom:0;'>$row[1]</h4>
<div>
<h6 class='card-subtitle text-muted' style='font-size:13px; display:inline;'>Last message</h6>
<h6 class='card-subtitle text-muted' style='font-size:13px; display:inline;'>&#8729;&nbsp;Today</h6>
</div>
</div>

</div>
</div>
<hr />
";
}


mysqli_close($conn);

?>