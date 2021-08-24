<?php
session_start();
include("./utilities.php");
check_session_id();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>twitter clone</title>
</head>

<body>
  <form action="./insert.php" method="POST">
    <fieldset>
      <legend>twitter clone（入力画面）<?= !$_SESSION['username'] ? '' : "Hi, {$_SESSION['username']}" ?></legend>
      <a href="./index.php">一覧画面</a>
      <a href="./logout.php">logout</a>
      <div>
        tweet: <input type="text" name="tweet">
      </div>
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>