<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$user = $_POST["userName"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}
#echo "Connected!";

$query = "
DELETE FROM UserAccount
WHERE userName = '$user'
";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_row($result)) {

}

mysqli_close($conn);

?>