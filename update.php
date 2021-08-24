<?php
session_start();
include("./utilities.php");
check_session_id();

if (
  !isset($_POST['tweet']) || $_POST['tweet'] == '' ||
  !isset($_POST['tweet_id']) || $_POST['tweet_id'] == ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$tweet = $_POST["tweet"];
$tweet_id = $_POST["tweet_id"];

$pdo = connect_to_db();

$sql = "UPDATE tweets SET tweet=:tweet, updated_at=now() WHERE tweet_id=:tweet_id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':tweet', $tweet, PDO::PARAM_STR);
$stmt->bindValue(':tweet_id', $tweet_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:./index.php");
  exit();
}
