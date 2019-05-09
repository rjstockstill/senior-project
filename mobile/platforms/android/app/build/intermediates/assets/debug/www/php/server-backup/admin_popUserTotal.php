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
SELECT COUNT(userAcc_id)
FROM UserAccount
";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_row($result)) {

echo "$row[0]";

}

mysqli_close($conn);

?>