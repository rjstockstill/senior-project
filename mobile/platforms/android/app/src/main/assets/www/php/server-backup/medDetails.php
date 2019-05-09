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
SELECT M.med_name, M.general_name, M.med_admin, M.med_purpose, M.med_desc, M.med_dosage, M.med_id
FROM Medicine AS M
WHERE M.med_name = '$medname'
";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_row($result)) {

echo "<div class='card' style='margin-bottom:10px;'>";
echo "<div class='card-header'>General Information</div>";
echo "<div class='card-body'>";
echo "<h5 class='card-title'>$row[0]</h5>";
echo "<p class='card-text text-muted'>$row[1]</p><hr/>";
echo "<p style='font-size:14px; font-weight:bold; color:#9068be; text-align:center; margin-bottom:0;'>Add to your cabinet</p>";
echo "</div>";
echo "</div>";



echo "<div class='card' style='margin-bottom:10px;'>";
echo "<div class='card-header'>Details</div>";
echo "<div class='card-body'>";

echo "<h5 class='card-title'>Administration Method</h5>";
echo "<p class='card-text text-muted'>$row[2]</p><hr/>";

echo "<h5 class='card-title'>Purpose</h5>";
echo "<p class='card-text text-muted'>$row[3]</p><hr/>";

echo "<h5 class='card-title'>Description</h5>";
echo "<p class='card-text text-muted'>$row[4]</p><hr/>";

echo "<h5 class='card-title'>Dosage Information</h5>";
echo "<p class='card-text text-muted'>$row[5]</p>";

echo "</div>";
echo "</div>";



echo "<div class='card' style='margin-bottom:10px;'>";
echo "<div class='card-header'>Recent Reviews<a><i class='fas fa-pen-nib' style='color:#9068be; float:right; line-height:26px;' title='Delete' onclick='openReviewForm(\"$row[0]\")'></i></a></div>";
echo "<div id='medReviewsDiv' class='card-body'>";


echo "</div>";
echo "</div>";
echo "<p id='idForReview' class='hidden'>$row[6]</p>";

}

mysqli_close($conn);

?>