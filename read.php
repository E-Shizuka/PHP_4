<?php
session_start();
include("functions.php");
check_session_id();

$pdo = connect_to_db();

// SQL作成&実行
$sql = 'SELECT * FROM data_table ORDER BY created_at DESC';

$stmt = $pdo->prepare($sql);

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
foreach ($result as $record) {
  $output .= "
    <div class=\"toko\">
      ";

  // if ($_SESSION['username'] == $record["username"]) {
  //   $output .= "
  //     <div class=\"ed-btn\">
  //       <button onclick=\"location.href='edit.php?id={$record["id"]}'\">edit</button>
  //       <button onclick=\"location.href='delete.php?id={$record["id"]}'\">delete</button>
  //     </div>
  //   ";
  // }

  $output .= "
      <div class=\"textDataArea\">{$record["username"]}さん</div>
      <div class=\"textDataArea\"><h2>{$record["title"]}</h2></div>
      <div class=\"textDataArea\" id=\"docDateText\">{$record["toko"]}</div>
      <div class=\"pictureArea\">
        <img src=\"/service2/img/{$record["img_name"]}\">
      </div>
    </div>
  ";
}

// foreach ($result as $record) {
//   $output .= "
//     <div class=\"toko\">
//       <div class=\"ed-btn\">
//         <button onclick=\"location.href='edit.php?id={$record["id"]}'\">edit</button>
//         <button onclick=\"location.href='delete.php?id={$record["id"]}'\">delete</button>
//       </div>
//       <div class=\"textDataArea\"><h2>{$record["title"]}</h2></div>
//       <div class=\"textDataArea\" id=\"docDateText\">{$record["toko"]}</div>
//       <div class=\"pictureArea\">
//         <img src=\"/service/img/{$record["img_name"]}\">
//       </div>
//     </div>
//   ";
// }

// echo "<pre>"; 
// //<pre>はオブジェクトを見やすく表示するためのタグ
// var_dump($result);
// echo "</pre>";
// exit();


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
        <button onclick="location.href='mypage.php'"
        class="tokoOpnbtn">マイページ</button>
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