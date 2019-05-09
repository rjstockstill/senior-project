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
SELECT UserAccount.userName, FROM_UNIXTIME(UNIX_TIMESTAMP(UserReview.created), '%M %D, %Y'), UserReview.rating, UserReview.comments
FROM Medicine, UserReview
LEFT JOIN UserAccount ON UserReview.userAcc_id = UserAccount.userAcc_id
WHERE Medicine.med_id = '$medid' AND Medicine.med_id = UserReview.med_id ORDER BY UserReview.created DESC LIMIT 3;
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

echo "<div style='width:100%; display:table;'>";
echo "<div style='display:table-cell; text-align:left;'>";
echo $rating;
echo "<br />";
echo "<p class='card-text text-muted' style='margin-bottom:0; font-size:14px; display:inline;'>$row[0]</p>";
echo "
<span class='fa-stack' style='vertical-align:middle; display:inline; font-size:6px;'>
  <i class='fas fa-certificate fa-stack-2x' style='padding-top:7px; color:#00aced'></i>
  <i class='fas fa-check fa-stack-1x' style='padding-top:7px; padding-left:3px; color:#fff;'></i>
</span>
";
echo "<p class='card-text text-muted' style='margin-bottom:0; padding-left:12px; font-size:14px; display:inline;'>&nbsp;&#8729;&nbsp;$row[1]</p>";
echo "<p class='card-text' style='padding-bottom:10px;'>\"$row[3]\"</p>";
echo "</div>";
echo "</div><hr/>";
}
echo "<p style='font-size:14px; font-weight:bold; color:#9068be; text-align:center; margin-bottom:0;'onclick='loadAllReviews($medid)'>Read more reviews</p>";


mysqli_close($conn);

?>