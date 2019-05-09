<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$medname = $_POST["medName"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}
#echo "Connected!";

$query = "
SELECT UserAccount.userName, FROM_UNIXTIME(UNIX_TIMESTAMP(UserReview.created), '%M %D, %Y'), UserReview.rating, UserReview.comments
FROM Medicine, UserReview
LEFT JOIN UserAccount ON UserReview.userAcc_id = UserAccount.userAcc_id
WHERE Medicine.med_id = UserReview.med_id AND Medicine.med_name = '$medname' ORDER BY UserReview.created DESC LIMIT 3;
";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_row($result)) {

echo "<div style='width:100%; display:table;'>";
echo "<div style='display:table-cell; text-align:left;'>";
echo "<p class='card-text text-muted' style='margin-bottom:0;'>$row[0] - $row[1]</p>";
echo "<p class='card-text' style='padding-bottom:10px;'>\"$row[3]\"</p>";
echo "</div>";
echo "<div style='display:table-cell; text-align:right;'>";
echo "<i class='fas fa-flag' style='color:#9068be;'></i>";
echo "</div>";
echo "</div><hr/>";

}
echo "<p style='font-size:14px; font-weight:bold; color:#9068be; text-align:center; margin-bottom:0;'>Read more reviews</p>";

mysqli_close($conn);

?>