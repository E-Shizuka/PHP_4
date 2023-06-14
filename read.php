<?php
session_start();
include("functions.php");
check_session_id();

$pdo = connect_to_db();
$user_id = $_SESSION['user_id'];

// SQL作成&実行
// $sql = 'SELECT * FROM data_table ORDER BY created_at DESC';

// $sql = 'SELECT * FROM data_table LEFT OUTER JOIN (SELECT data_id, COUNT(id) AS like_count FROM like_table GROUP BY data_id) AS result_table
// ON data_table.id = result_table.data_id
// ORDER BY created_at DESC';

$sql = 'SELECT * FROM data_table LEFT OUTER JOIN (SELECT user_id, data_id, COUNT(id) AS like_count FROM like_table GROUP BY data_id) AS result_table ON data_table.id = result_table.data_id ORDER BY created_at DESC';

$sql2 = 'SELECT data_id FROM like_table WHERE user_id=user_id';

// $sql2 = 'SELECT data_id FROM like_table WHERE user_id<>:user_id'; 


$stmt = $pdo->prepare($sql);
$stmt2 = $pdo->prepare($sql2);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error1" => "{$e->getMessage()}"]);
  exit();
}

try {
  $status = $stmt2->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error2" => "{$e->getMessage()}"]);
  exit();
}

//「ユーザが入力したデータ」を使用しないので読み込み時はバインド変数不要

//投稿にいいねしてるかしてないかを集計


$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

// //  var_dump($result);
//  var_dump($result2);
//  exit();

$output = "";
foreach ($result as $record) {
    $output .= "
      <div class=\"toko\" id=\"{$record['id']}\" value=\"{$record['id']}\">

      <div class=\"textDataArea\"><a href=\"userpage.php?username={$record['username']}\">{$record['username']}さん</a></div>
        <div>
          <button class=\"zero-like\" onclick=\"location.href='like_create.php?user_id={$user_id}&data_id={$record['id']}';\">like{$record['like_count']}</button>
        </div>
        <div class=\"textDataArea\"><h2>{$record['title']}</h2></div>
        <div class=\"textDataArea\" id=\"docDateText\">{$record['toko']}</div>
        <div class=\"pictureArea\">
          <img src=\"/service2/img/{$record['img_name']}\">
        </div>
      </div>
    ";
  }
// echo json_encode($result2);
//↑このコードは同じファイルにjs書いている場合はechoしなくていい。別ファイルで作業する場合は必要。

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
        <!-- <button onclick="openModal()" class="tokoOpnbtn">投稿する</button> -->
        <button onclick="location.href='logout.php'"
        class="tokoOpnbtn">logout</button>
        <button onclick="openModal('input.php')" class="tokoOpnbtn">投稿する</button>
        <button onclick="openModal('calendar.php')" class="tokoOpnbtn">予約カレンダー</button>
        <button onclick="location.href='kimono_read.php'"
        class="tokoOpnbtn">着物一覧へ</button>
      </div>
      <div class="a-box">
        <div id="myModal" class="modal">
          <div class="modal-content">
            <span class="close">&times;</span>
            <!-- モーダルの内容をここに追加 -->
            <iframe id="modalContent"></iframe>
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
    function openModal(url) {
      $("#myModal").css("display", "block");
      $("#modalContent").attr("src", url);
    }

    function closeModal() {
      $("#myModal").css("display", "none");
      $("#modalContent").attr("src", "");
    }

    $(document).ready(function() {
      $(".close").click(function() {
        closeModal();
        location.reload();
      });
    });

    const result_id = <?php echo json_encode($result2); ?>;
    console.log(result_id);

    const value = $('.toko').attr('value');
    console.log(value);
    console.log(result_id[0].data_id);

    for (let result_id2 of result_id) {
      console.log(result_id2.data_id);
      const box_id = result_id2.data_id;
      console.log($("#" + box_id).find("button"));
      const findbtn = $("#" + box_id).find("button");
      $(findbtn).removeClass("zero-like").addClass("button2");
    } 
    

</script>

</body>

</html>

