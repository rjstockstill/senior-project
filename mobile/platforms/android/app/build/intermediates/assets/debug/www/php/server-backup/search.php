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
#echo "Connected!";

$stmt = $conn->prepare('SELECT M.med_name, M.general_name FROM Medicine as M WHERE M.med_name LIKE ?');
$searchKeyword = $q . '%';
$stmt->bind_param('s', $searchKeyword);
$stmt->execute();

$result = $stmt->get_result();

while($row = $result->fetch_row()) {
  echo "<div class='card cardshadow' onclick='openMedDetails(\"$row[0]\")'>";
  echo "<div class='card-body'>";
  echo "<h5 class='card-title'>$row[0]</h5>";
  echo "<h6 class='card-subtitle mb-2 text-muted'>$row[1]</h6>";
  echo "<br/>";
  echo "<p class='card-text' style='color:green;'>$row[2]</p>";
  echo "</div>";
  echo "</div>";
}

mysqli_close($conn);

?>