<?php
session_start();
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'])) {
    $yoyaku="";
    $date = $_POST['date'];
    $yoyaku .= "$date";
}


?>
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
  <title>blog</title>
</head>

<body>
    <div class="all">
    <div class="a-box">
        <button onclick="location.href='calendar.php'" class="tokoOpnbtn">戻る</button>
    </div>
    <form action="reservation_calender.php" method="POST">
    <fieldset>
      <legend>予約入力画面</legend>
      <!-- <a href="read.php">一覧画面</a> -->
      <div class="tokobox2">
        <div class="input">
            お名前
        <input type="text" name="name" placeholder="佐藤　太郎" class="textarea">
        </div>
      </div>
      <div class="tokobox2">
        <div class="input">
            電話番号
        <input type="tel" name="number" placeholder="000-0000-0000" class="textarea">
        </div>
      </div>
      <div class="tokobox2">
        <div class="input">
            e-mail
        <input type="email" name="email" placeholder="test@test.com" class="textarea">
        </div>
      </div>
      <div class="tokobox2">
        <div class="input">
            予約日時
        <input type="date" name="day" list="daylist" min="" class="textarea" value="<?= $yoyaku ?>" readonly>
        </div>
      </div>
      <div class="tokobox2">
          <button class="tokobtn">予約</button>
        </div>
    </fieldset>
</form>
  </div>

</body>

</html>