<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/reset.css" />
  <link rel="stylesheet" type="text/css" href="css/sanitize.css" />
  <link
    href="https://fonts.googleapis.com/earlyaccess/kokoro.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" type="text/css" href="css/style.css" />

  <title>新規ユーザ登録画面</title>
</head>

<body>
  <div class="registerform">
  <button class="button3" onclick="location.href='login.php'">すでに登録済の方はこちら</button>
  </div>
  <form action="register_act.php" method="POST">
    <div id="loginform">
    <fieldset>
      <legend>新規ユーザ登録画面</legend>
      <div class="input">
        username: <input type="text" name="username" class="textarea">
      </div>
      <div class="input">
        password: <input type="text" name="password" class="textarea">
      </div>
      <div class="tokobox">
        <button class="tokobtn">登録</button>
      </div>
      <p>新規ユーザー登録後、ログインページにてログインしてください。</p>
    </fieldset>
  </div>
</form>

</body>

</html>