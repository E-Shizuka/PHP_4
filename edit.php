<?php
session_start();
include("functions.php");
check_session_id();

$id = $_GET["id"];

$pdo = connect_to_db();

$sql = 'SELECT * FROM data_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);

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
  <title>blog（編集画面）</title>
</head>

<body>
  <form action="update.php" method="POST" method="POST" enctype="multipart/form-data">
    <fieldset>
      <legend>編集画面</legend>
      <!-- <a href="read.php">一覧画面</a> -->
      <div class="tokobox">
        <div class="title">
        タイトル：
        </div>
        <div class="input">
        <input type="text" name="title" class="textarea" value="<?= $record["title"] ?>">
        </div>
      </div>
      <div class="tokobox">
        <div class="title">
        投稿内容：
        </div>
        <div class="input">
          <textarea rows="10" cols="60" name="toko" class="textarea"><?= $record["toko"] ?></textarea>
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
      <input type="hidden" name="id" value="<?= $record["id"] ?>">
      <input type="hidden" name="old_img_name" value="<?= $record["img_name"] ?>">
    </fieldset>
  </form>

</body>

</html>