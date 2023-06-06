<?php
session_start();
include("functions.php");
check_session_id();
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
  <form action="create.php" enctype="multipart/form-data" method="POST">
    <fieldset>
      <legend>投稿入力画面</legend>
      <!-- <a href="read.php">一覧画面</a> -->
      <div class="tokobox">
        <div class="title">
        タイトル：
        </div>
        <div class="input">
        <input type="text" name="title" class="textarea">
        </div>
      </div>
      <div class="tokobox">
        <div class="title">
        投稿内容：
        </div>
        <div class="input">
          <textarea rows="10" cols="60" name="toko" class="textarea"></textarea>
        </div>
      </div>
      <div class="tokobox">
        <div class="title">画像：
        </div>
        <div class="input">
        <input type="file" name="img_name" accept=".jpg,.jpeg,.png" required>
        </div>
      </div>
      <div class="tokobox">
        <button class="tokobtn">投稿</button>
      </div>
    </fieldset>
  </form>

</body>

</html>