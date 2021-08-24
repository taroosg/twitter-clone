<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <form action="./login_act.php" method="POST">
    <fieldset>
      <legend>twitter clone</legend>
      <div>
        username: <input type="text" name="username">
      </div>
      <div>
        password: <input type="text" name="password">
      </div>
      <div>
        <button>Login</button>
      </div>
      <a href="./register.php">or register</a>
      <a href="./index.php">一覧画面</a>
    </fieldset>
  </form>
</body>

</html>