<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$userid = $_POST["userID"];
$medid = $_POST["medID"];
$medname = $_POST["medName"];
$medgeneral = $_POST["medGeneral"];
$medmanuf = $_POST["medManuf"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$query = "
SELECT M.med_name, M.general_name, M.med_admin, M.med_purpose, M.med_dosage, M.med_id, M.med_reactions, M.med_warnings, M.med_manufacturer
FROM Medicine AS M
WHERE M.med_id = '$medid'
";

$result = mysqli_query($conn, $query);
$cabinet = "Add to your cabinet";
$added = 0;

$checker_query = "
SELECT userAcc_id, med_id
FROM UserMeds
WHERE userAcc_id = '$userid' AND med_id = '$medid'
";

$checker_result = mysqli_query($conn, $checker_query);
while($row = mysqli_fetch_row($checker_result)) {
  if($row[0] == $userid && $row[1] == $medid) {
    $cabinet = "Currently in your cabinet!";
    $added = 1;
  }
}

while($row = mysqli_fetch_row($result)) {

$average = 0;

$avg_query = "
SELECT AVG(rating)
FROM UserReview
WHERE med_id = '$medid'
";

$avg_result = mysqli_query($conn, $avg_query);
while($avg_row = mysqli_fetch_row($avg_result)) {
  $average = floor($avg_row[0]);
}


$rating_full = "<i class='fas fa-star' style='position:static; font-size:18px; color:gold;'></i>";
$rating_half = "<i class='fas fa-star-half-alt' style='position:static; font-size:18px; color:gold;'></i>";
$rating_empty = "<i class='far fa-star' style='position:static; font-size:18px; color:gold;'></i>";

$rating_full_none = "<i class='fas fa-star' style='position:static; font-size:18px; color:silver;'></i>";
$rating_half_none = "<i class='fas fa-star-half-alt' style='position:static; font-size:18px; color:silver;'></i>";
$rating_empty_none = "<i class='far fa-star' style='position:static; font-size:18px; color:silver;'></i>";

$rating = "";

switch(intval($average)) {
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
  default: $rating = $rating_empty_none . $rating_empty_none . $rating_empty_none . $rating_empty_none . $rating_empty_none;
}


$adverse = substr($row[6], 0, 1000);
$warnings = substr($row[7], 0, 1000);

if(strlen($adverse) >= 1000) {
  $adverse = $adverse . "...";
}

if(strlen($warnings) >= 1000) {
  $warnings = $warnings . "...";
}


$review_html = "
<div class='card-header'>Recent Reviews
<a><i class='fas fa-plus' style='color:#9068be; float:right; line-height:26px;' title='Delete' onclick='openReviewForm(\"$row[0]\")'></i></a>
</div>
";

$review_query = "
SELECT userAcc_id
FROM UserReview
WHERE med_id = '$medid' AND userAcc_id = '$userid'
";

$review_result = mysqli_query($conn, $review_query);
while($review_row = mysqli_fetch_row($review_result)) {
  if($review_row[0] == $userid) {
    $review_html = "
      <div class='card-header'>Recent Reviews<a><i class='fas fa-pen-nib' style='color:#9068be; float:right; line-height:26px;' title='Delete' onclick='editReviewForm(\"$row[5]\")'></i></a></div>
    ";
  }
}


$effect_arr = array();
$effects = "No user-reported side effects yet.";

$effect_query = "
SELECT side_1, side_2, side_3, side_4, side_5
FROM UserReview
WHERE med_id = '$medid'
";

$effect_result = mysqli_query($conn, $effect_query);
while($effect_row = mysqli_fetch_row($effect_result)) {
  if(!empty($effect_row[0])) {
    $effect_arr[] = $effect_row[0];
  }
  if(!empty($effect_row[1])) {
    $effect_arr[] = $effect_row[1];
  }
  if(!empty($effect_row[2])) {
    $effect_arr[] = $effect_row[2];
  }
  if(!empty($effect_row[3])) {
    $effect_arr[] = $effect_row[3];
  }
  if(!empty($effect_row[4])) {
    $effect_arr[] = $effect_row[4];
  }
}

if(!empty($effect_arr)) {
  $effect_counter = 0;
  $effects = "Users tend to experience ";
  foreach($effect_arr as $item) {
    if($effect_counter != 0) {
      $effects .= ", " . $item;
    } else {
      $effects .= $item;
    }
    $effect_counter++;
  }
}


echo "
<div class='card' style='margin-bottom:10px;'>
<div class='card-header'>General Information</div>
<div class='card-body'>
<p class='card-text text-muted'>$rating</p>
<h5 id='openMedDetails_name' class='card-title'>$row[0]</h5>
<p id='openMedDetails_general' class='card-text text-muted' style='font-size:14px; margin-bottom:0;'>$row[1]</p>
<p id='openMedDetails_manuf' class='card-text text-muted' style='font-size:14px; margin-bottom:0;'>Manufacturer: $row[8]</p>
<p class='card-text text-muted' style='font-size:14px; font-style:italic;'>$effects</p>
<hr/>
<p style='font-size:14px; font-weight:bold; color:#9068be; text-align:center; margin-bottom:0;' onclick='addMedicineToCabinet($userid, $row[5], $added, \"$row[0]\", \"$row[1]\", \"$row[8]\")'>$cabinet</p>
</div>
</div>


<div class='card' style='margin-bottom:10px;'>
<div class='card-header'>Expert Opinions</div>
<div id='expertOpinionsDiv' class='card-body'>
<p class='card-text text-muted' style='font-style:italic; font-size:14px;'>No experts have left reviews yet.</p>
</div>
</div>


<div class='card' style='margin-bottom:10px;'>
$review_html
<div id='medReviewsDiv' class='card-body'>
<p class='card-text text-muted' style='font-style:italic; font-size:14px;'>No users have left reviews yet.</p>
</div>
</div>


<div class='card' style='margin-bottom:10px;'>
<div class='card-header'>Details</div>
<div class='card-body'>

<h5 class='card-title'>Administration Method</h5>
<p class='card-text text-muted' style='font-size:14px;'>$row[2]</p><hr/>

<h5 class='card-title'>Purpose</h5>
<p class='card-text text-muted' style='font-size:14px;'>$row[3]</p><hr/>

<h5 class='card-title'>Dosage Information</h5>
<p class='card-text text-muted' style='font-size:14px;'>$row[4]</p>

<h5 class='card-title'>Adverse Reactions</h5>
<p class='card-text text-muted' style='font-size:14px;'>$adverse</p>

<h5 class='card-title'>Warnings</h5>
<p class='card-text text-muted' style='font-size:14px;'>$warnings</p>

</div>
</div>


<p id='idForReview' style='color:transparent;'>$row[5]</p>
<p id='userid_tag' style='color:transparent;'>$userid</p>
";
break;
}


mysqli_close($conn);

?>