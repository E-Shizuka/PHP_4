<?php
session_start();
include("functions.php");
check_session_id();

$pdo = connect_to_db();

// SQL作成&実行
$sql = "SELECT * FROM data_table WHERE username = :username ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);

// バインド変数の設定
$stmt->bindValue(':username', $_SESSION['username'], PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//「ユーザが入力したデータ」を使用しないので読み込み時はバインド変数不要

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";

// 投稿がない場合のフラグ
$hasPosts = false;

foreach ($result as $record) {
    // 自分の投稿のみ表示
    if ($record["username"] === $_SESSION['username']) {
        $output .= "
            <div class=\"toko\">
            <div class=\"ed-btn\">
                <button class=\"button2\"  onclick=\"location.href='edit.php?id={$record["id"]}'\">edit</button>
                <button class=\"button2\"  onclick=\"location.href='delete.php?id={$record["id"]}'\">delete</button>
            </div>
            <div class=\"textDataArea\">{$record["username"]}さん</div>
            <div class=\"textDataArea\"><h2>{$record["title"]}</h2></div>
            <div class=\"textDataArea\" id=\"docDateText\">{$record["toko"]}</div>
            <div class=\"pictureArea\">
                <img src=\"/service2/img/{$record["img_name"]}\">
            </div>
            </div>
        ";

         // 投稿がある場合にフラグを立てる
        $hasPosts = true;
    } 
}

// 投稿がない場合の表示
if (!$hasPosts) {
    $output .= "
        <div class=\"toko\">
        <p>投稿がありません。</p>
        </div>
    ";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/reset.css" />
  <link rel="stylesheet" type="text/css" href="css/sanitize.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <link
    href="https://fonts.googleapis.com/earlyaccess/kokoro.css"
    rel="stylesheet"
  />
  <title>blog</title>
</head>

<body>
  <div class="all">
    <div class="fixed-top">
      <div class="a-box">
        <button onclick="openModal()" class="tokoOpnbtn">投稿する</button>
        <button onclick="location.href='logout.php'"
        class="tokoOpnbtn">logout</button>
      </div>
      <div class="a-box">
        <div id="myModal" class="modal">
          <div class="modal-content">
            <span class="close">&times;</span>
            <!-- モーダルの内容をここに追加 -->
            <iframe src="input.php"></iframe>
          </div>
        </div>
        <h1 class="nikkiP"><legend>おでかけ日記</legend></h1>
        <button onclick="location.href='read.php'"
        class="tokoOpnbtn">タイムライン</button>
        <p class="nikkiP">こんにちは<?=$_SESSION['username']?>さん</p>
    </div>
      <div class="scrollable">
        <div id="output">
          <?= $output ?>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    function openModal() {
  $("#myModal").css("display", "block");
}

function closeModal() {
  $("#myModal").css("display", "none");
}

$(document).ready(function() {
  $(".close").click(function() {
    closeModal();
    location.reload();
  });

});
</script>

</body>

</html>