<?php
session_start();
include("./utilities.php");
check_session_id();

$tweet_id = $_GET["tweet_id"];
$source = $_GET["source"];

$pdo = connect_to_db();

$sql = "DELETE FROM tweets WHERE tweet_id=:tweet_id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':tweet_id', $tweet_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header($source == 0 ? "Location:./index.php" : "Location:./likes.php");
  exit();
}
