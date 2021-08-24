<?php
session_start();
include("./utilities.php");
check_session_id();

if (
  !isset($_POST['tweet']) || $_POST['tweet'] == ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$tweet = $_POST['tweet'];
$user_id = $_SESSION['user_id'];
var_dump($user_id);

$pdo = connect_to_db();

$sql = 'INSERT INTO tweets(tweet_id, tweet, user_id, created_at, updated_at) VALUES(NULL, :tweet, :user_id, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':tweet', $tweet, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:./index.php");
  exit();
}
