<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$medid = $_POST["medID"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$query = "
SELECT UserAccount.userName, FROM_UNIXTIME(UNIX_TIMESTAMP(UserReview.created), '%M %D, %Y'), UserReview.rating, UserReview.comments, UserReview.upvotes, UserReview.userReview_id
FROM Medicine, UserReview
LEFT JOIN UserAccount ON UserReview.userAcc_id = UserAccount.userAcc_id
WHERE Medicine.med_id = '$medid' AND Medicine.med_id = UserReview.med_id ORDER BY UserReview.created DESC;
";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_row($result)) {

$rating_full = "<i class='fas fa-star' style='position:static; font-size:14px; color:gold;'></i>";
$rating_half = "<i class='fas fa-star-half-alt' style='position:static; font-size:14px; color:gold;'></i>";
$rating_empty = "<i class='far fa-star' style='position:static; font-size:14px; color:gold;'></i>";
$rating = "";

switch(intval($row[2])) {
  case 1: $rating = $rating_half . $rating_empty . $rating_empty . $rating_empty . $rating_empty; break;
  case 2: $rating = $rating_full . $rating_empty . $rating_empty . $rating_empty . $rating_empty; break;
  case 3: $rating = $rating_full . $rating_half . $rating_empty . $rating_empty . $rating_empty; break;
  case 4: $rating = $rating_full . $rating_full . $rating_empty . $rating_empty . $rating_empty; break;
  case 5: $rating = $rating_full . $rating_full . $rating_half . $rating_empty . $rating_empty; break;
  case 6: $rating = $rating_full . $rating_full . $rating_full . $rating_empty . $rating_empty; break;
  case 7: $rating = $rating_full . $rating_full . $rating_full . $rating_half . $rating_empty; break;
  case 8: $rating = $rating_full . $rating_full . $rating_full . $rating_full . $rating_empty; break;
  case 9: $rating = $rating_full . $rating_full . $rating_full . $rating_full . $rating_half; break;
  case 10: $rating = $rating_full . $rating_full . $rating_full . $rating_full . $rating_full; break;
  default: $rating = "";
}

echo "
<div class='card' style='border:none;'>
<div class='card-body' style='padding:15px;'>

<div style='width:100%; display:table;'>

<div style='text-align:left;'>
$rating
<p class='card-text text-muted' style='margin-bottom:0; font-size:14px;'>$row[0]&nbsp;&#8729;&nbsp;$row[1]</p>
<p class='card-text'>$row[3]</p>
<div style='font-size:14px; margin-top:-15px;'>
<p class='card-text' style='color:silver; display:inline;' onclick='changeCol(this);'>Like</p>
<p class='card-text' style='color:silver; display:inline;' onclick='replyToReview($row[5], \"$row[0]\")'>&nbsp;&#8729;&nbsp;&nbsp;Reply</p>
<p class='card-text' style='color:silver; display:inline; float:right;'>$row[4]</p>
<i class='far fa-thumbs-up' style='color:silver; display:inline; float:right; padding-top:4px;'>&nbsp;</i>
</div>
</div>
</div>

<div id='reviewReplyDiv' style='padding-left:35px;'>
";


$reply_query = "
SELECT UserAccount.userName, ReviewReply.created, ReviewReply.comments FROM UserReview, ReviewReply LEFT JOIN UserAccount ON UserAccount.userAcc_id=ReviewReply.userAcc_id WHERE UserReview.med_id=270223 AND UserReview.userReview_id=ReviewReply.userReview_id AND UserAccount.userAcc_id=ReviewReply.userAcc_id AND UserAccount.userName='$row[0]'
";

$reply_result = mysqli_query($conn, $reply_query);
while($reply_row = mysqli_fetch_row($reply_result)) {
  echo "
  <div style='text-align:left;'>
  <p class='card-text text-muted' style='margin-bottom:0; font-size:14px;'>$reply_row[0]&nbsp;&#8729;&nbsp;$reply_row[1]</p>
  <p class='card-text'>$reply_row[2]</p>
  <div style='font-size:14px; margin-top:-15px; margin-bottom:15px;'>
  <p class='card-text' style='color:silver; display:inline;' onclick='changeCol(this);'>Like</p>
  <p class='card-text' style='color:silver; display:inline; float:right;'>$reply_row[3]</p>
  <i class='far fa-thumbs-up' style='color:silver; display:inline; float:right; padding-top:4px;'>&nbsp;</i>
  </div>
  </div>
  ";
}


echo "
</div>
</div>
</div>
<hr/>
";
}


mysqli_close($conn);

?>