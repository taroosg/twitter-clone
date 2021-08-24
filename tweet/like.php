<?php

include('../utilities.php');

$user_id = $_GET['user_id'];
$tweet_id = $_GET['tweet_id'];
$source = $_GET['source'];

$pdo = connect_to_db();

$sql = 'SELECT COUNT(*) FROM likes WHERE user_id=:user_id AND tweet_id=:tweet_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':tweet_id', $tweet_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $like_count = $stmt->fetchColumn();
  // exit();
}

if ($like_count != 0) {
  // いいねされている状態
  $sql = 'DELETE FROM likes WHERE user_id=:user_id AND tweet_id=:tweet_id';
} else {
  // いいねされていない状態
  $sql = 'INSERT INTO likes (user_id, tweet_id, created_at) VALUES (:user_id, :tweet_id, now())';
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':tweet_id', $tweet_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header($source == 0 ? "Location:./index.php" : "Location:./likes.php");
  exit();
}
