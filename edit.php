<?php
session_start();

include("./utilities.php");
check_session_id();

$tweet_id = $_GET["tweet_id"];

$pdo = connect_to_db();

$sql = 'SELECT * FROM tweets WHERE tweet_id=:tweet_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':tweet_id', $tweet_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
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
  <form action="./update.php" method="POST">
    <fieldset>
      <legend>twitter clone（編集画面）</legend>
      <a href="./index.php">一覧画面</a>
      <div>
        tweet: <input type="text" name="tweet" value="<?= $record["tweet"] ?>">
      </div>
      <div>
        <button>submit</button>
      </div>
      <input type="hidden" name="tweet_id" value="<?= $record["tweet_id"] ?>">
    </fieldset>
  </form>

</body>

</html>