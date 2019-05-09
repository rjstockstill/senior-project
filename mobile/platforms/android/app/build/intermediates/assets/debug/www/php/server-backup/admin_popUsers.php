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
SELECT U.userAcc_id, U.userName
FROM UserAccount as U
";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_row($result)) {

echo "<li class='list-group-item'>ID#:$row[0] | UN:$row[1]";
echo "<div>";
echo "<button class='btn btn-danger' style='float:right;' data-toggle='modal' data-target='#deleteUserModal' onclick='changeDeleteUsername(\"$row[1]\")'>";
echo "<i class='fas fa-trash' style='color:#fff;' title='Delete'></i>";
echo "</button>";
echo "</div>";
echo "</li>";

}

mysqli_close($conn);

?>