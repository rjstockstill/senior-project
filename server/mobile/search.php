<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$q = $_POST["medSearchbar"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('SELECT M.med_id, M.med_name, M.general_name, M.med_manufacturer, M.med_rxcui, M.med_ndc FROM Medicine as M WHERE M.med_name LIKE ? OR M.general_name LIKE ? OR M.med_manufacturer LIKE ? OR M.med_ndc LIKE ? LIMIT 10');
$searchKeyword = $q . '%';
$stmt->bind_param('ssss', $searchKeyword, $searchKeyword, $searchKeyword, $searchKeyword);
$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_row()) {

  $url = "https://rximage.nlm.nih.gov/api/rximage/1/rxbase?rxcui=" . intval($row[4]) . "&resolution=120&rLimit=5";
  $json = file_get_contents($url);
  $json_data = json_decode($json, true);
  $img = $json_data["nlmRxImages"][0]["imageUrl"];
  for($x = 0; x < $json_data["nlmRxImages"].count(); $x++) {
    if($json_data["nlmRxImages"][$x]["relabelersNdc9"]["@sourceNdc9"] == '$row[5]') {
      $img = $json_data["nlmRxImages"][$x]["imageUrl"];
    }
  }

$average = 0;

$avg_query = "
SELECT AVG(rating)
FROM UserReview
WHERE med_id = '$row[0]'
";

$avg_result = mysqli_query($conn, $avg_query);
while($avg_row = mysqli_fetch_row($avg_result)) {
  $average = floor($avg_row[0]);
}

$rating_full = "<i class='fas fa-star' style='position:static; font-size:14px; color:gold;'></i>";
$rating_half = "<i class='fas fa-star-half-alt' style='position:static; font-size:14px; color:gold;'></i>";
$rating_empty = "<i class='far fa-star' style='position:static; font-size:14px; color:gold;'></i>";

$rating_full_none = "<i class='fas fa-star' style='position:static; font-size:14px; color:silver;'></i>";
$rating_half_none = "<i class='fas fa-star-half-alt' style='position:static; font-size:14px; color:silver;'></i>";
$rating_empty_none = "<i class='far fa-star' style='position:static; font-size:14px; color:silver;'></i>";

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


  echo "<div class='card cardshadowmed' onclick='openMedDetails(\"$row[0]\",\"$row[1]\",\"$row[2]\",\"$row[3]\")' style='background-repeat:no-repeat; background-size:30%; background-position:right bottom; background-image:linear-gradient(to right, rgba(255,255,255,1), rgba(255,255,255,0)), url($img);'>";
  echo "<div class='card-body'>";
  echo "<h5 class='card-title' style='color:#9068be;'>$row[1]</h5>";
  echo "<p class='card-text text-muted'>$rating</p>";
  echo "<hr/>";

  echo "<span class='card-subtitle mb-2 text-muted' style='font-size:14px; font-weight:bold; display:inline;'>GENERIC NAME: </span><span class='card-subtitle mb-2 text-muted' style='font-size:14px; display:inline;'>$row[2]</span>";
  echo "<br/>";
  echo "<span class='card-subtitle mb-2 text-muted' style='font-size:14px; font-weight:bold; display:inline;'>MANUFACTURER: </span><span class='card-subtitle mb-2 text-muted' style='font-size:14px; display:inline;'>$row[3]</span>";
  echo "<br/>";
  echo "<span class='card-subtitle mb-2 text-muted' style='font-size:14px; font-weight:bold; display:inline;'>National Drug Code (NDC): </span><span class='card-subtitle mb-2 text-muted' style='font-size:14px; display:inline;'>$row[5]</span>";
  echo "<br/><br/><br/>";
  echo "<p class='card-text' style='color:#9068be; font-size:14px; font-weight:bold;'>CLICK FOR MORE</p>";

  echo "</div>";
  echo "</div>";
}


mysqli_close($conn);

?>