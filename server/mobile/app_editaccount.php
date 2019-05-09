<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$editFirst = $_POST["editFirst"];
$editLast = $_POST["editLast"];
$editUsername = $_POST["editUsername"];
$editPass = $_POST["editPass"];
$userID = $_POST["userID"];

$hashedPass = hash('sha512', $editPass);

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('UPDATE UserAccount SET first_name = IF(? = "", first_name, ?), last_name = IF(? = "", last_name, ?), userName = IF(? = "", userName, ?), userPass = IF(? = "", userPass, ?) WHERE userAcc_id = ?');
$stmt->bind_param('ssssssssi', $editFirst, $editFirst, $editLast, $editLast, $editUsername, $editUsername, $editPass, $hashedPass, $userID);

if($stmt->execute()) { echo "success"; }
else { echo "failure"; }

mysqli_close($conn);

?>