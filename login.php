<!-- ログインチェック関数を入れちゃだめ
ログアウトしている状態の人が来るので無限ループになる -->

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
  <title>着物ファン</title>
</head>

<body>
  <div class="welcome">
  <h2>着物の世界へようこそ！</h2>
  <p>着物の一覧は<button onclick="location.href= 'kimono_read.php'" class="button4">こちら</button>からどうぞ</p>
  <p>着物苑へのオンライン訪問の予約は<button onclick="location.href= 'calendar.php'" class="button4">こちら</button>からどうぞ</p>
  </div>
  <div class="imgArea"></div>
  <div class="registerform">
  <button class="button5" onclick="location.href='register.php'">新規ユーザー登録はこちら</button>
  </div>
  <form action="login_act.php" method="POST">
    <div id="loginform">
    <fieldset>
      <legend>おでかけ日記ログイン画面</legend>
      <div class="input">
        username: <input type="text" name="username" class="textarea">
      </div>
      <div class="input">
        password: <input type="password" name="password" class="textarea">
      </div>
      <div class="tokobox">
        <button class="tokobtn">Login</button>
      </div>
    </fieldset>
    </div>
  </form>

</body>

</html>