<?php
header('Access-Control-Allow-Origin: *');

$servername = "dbserv.cs.siu.edu";
$username = "mls";
$password = "pZR5i2ts";
$dbname = "mls";
$review_userID = $_POST["review_userID"];
$review_medID = $_POST["review_medID"];
$review_rating = $_POST["review_rating"];
$review_birthdate = $_POST["review_birthdate"];
$review_side1 = $_POST["review_side1"];
$review_side2 = $_POST["review_side2"];
$review_side3 = $_POST["review_side3"];
$review_side4 = $_POST["review_side4"];
$review_side5 = $_POST["review_side5"];
$review_comments = $_POST["review_comments"];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
  die("Connection failed: " . mysqli_connect_error() . "\n");
}

$stmt = $conn->prepare('INSERT INTO UserReview VALUES (0,?,?,NOW(),?,?,?,?,?,?,?,?,0,0,0)');
$stmt->bind_param('iiisssssss', $review_userID, $review_medID, $review_rating, $review_birthdate, $review_side1, $review_side2, $review_side3, $review_side4, $review_side5, $review_comments);
$stmt->execute();


mysqli_close($conn);

?>