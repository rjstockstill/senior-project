<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
#$q = $_POST["medSearchbar"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}
#echo "Connected!";

$query = "
SELECT M.med_id, M.med_name, M.general_name
FROM Medicine as M
";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_row($result)) {

echo "<li class='list-group-item'>ID#:$row[0] | Brand:$row[1]<br/>General:$row[2]";
echo "<button class='btn btn-danger' style='float:right; margin-left:5px;'>";
echo "<i class='fas fa-trash' style='color:#fff;' title='Delete'></i>";
echo "</button>";
echo "<button class='btn btn-primary' style='float:right;'>";
echo "<i class='fas fa-pen-nib' style='color:#fff;' title='Edit'></i>";
echo "</button>";
echo "</li>";

}

mysqli_close($conn);

?>