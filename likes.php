<?php
session_start();
include("./utilities.php");

$user_id = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;

$pdo = connect_to_db();

$sql = 'SELECT tweet_id, tweet, created_at, updated_at, cnt, user_id, username FROM (SELECT tweet_id, tweet, user_id AS u_id, created_at, updated_at, cnt FROM tweets INNER JOIN (SELECT tweet_id AS id, COUNT(tweet_id) AS cnt FROM likes GROUP BY tweet_id) AS result_table ON tweets.tweet_id = result_table.id) AS tweet_table INNER JOIN (SELECT user_id, username FROM users) AS users ON tweet_table.u_id = users.user_id ORDER BY created_at DESC';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $output = implode(
    '',
    array_map(
      fn ($x) =>
      !$user_id
        ? "<tr><td>{$x["created_at"]}</td><td>{$x["username"]}</td><td>{$x["tweet"]}</td><td>like{$x['cnt']}</td>"
        : ($user_id !== $x["user_id"]
          ? "<tr><td>{$x["created_at"]}</td><td>{$x["username"]}</td><td>{$x["tweet"]}</td><td><a href='./like.php?user_id={$user_id}&tweet_id={$x["tweet_id"]}&source=0'>like{$x['cnt']}</a></td>"
          : "<tr><td>{$x["created_at"]}</td><td>{$x["username"]}</td><td>{$x["tweet"]}</td><td><a href='./like.php?user_id={$user_id}&tweet_id={$x["tweet_id"]}&source=0'>like{$x['cnt']}</a></td><td><a href='./edit.php?tweet_id={$x["tweet_id"]}'>edit</a></td><td><a href='./delete.php?tweet_id={$x["tweet_id"]}'>delete</a></td></tr>"),
      $result,
    )
  );
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>twitter clone</title>
</head>

<body>
  <fieldset>
    <legend>twitter clone（Like画面）<?= !$username ? '' : "Hi, {$username}" ?></legend>
    <?= !$user_id ? "<a href=\"./login.php\">login</a>" : "<a href=\"./create.php\">入力画面</a> <a href=\"./index.php\">一覧画面</a> <a href=\"./logout.php\">logout</a>" ?>
    <table>
      <thead>
        <tr>
          <th>tweet</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>