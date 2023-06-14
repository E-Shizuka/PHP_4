<?php
session_start();
include('functions.php');
$pdo = connect_to_db();


// $sql = 'SELECT * FROM kimono_search ORDER BY created_at DESC';

$sql = 'SELECT * FROM kimono_search LEFT OUTER JOIN kimono_pattern ON kimono_search.pattern_id = kimono_pattern.id ORDER BY kimono_search.created_at DESC';


$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//  var_dump($result);
//  exit();

$output = "";
foreach ($result as $record) {
    $output .= "
      <div class=\"ichiran\" id=\"{$record['id']}\">

        <div class=\"textDataArea\"><h3>{$record['pattern']}</h3>
        <p>{$record['gofuku']}</p></div>
      
        <div class=\"pictureArea\">
          <img src=\"{$record['img_name']}\">
        </div>
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
  <link
    href="https://fonts.googleapis.com/earlyaccess/kokoro.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <title>着物一覧</title>
</head>

<body>
  <fieldset>
    <legend>着物一覧</legend>
    <a href="kimono_input.php">検索画面</a>
    <table>
      <div>
        <h2>検索結果</h2>
      </div>
      <tbody>
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
  <div class="all">
    <div class="fixed-top">
      <div class="a-box">
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1): ?>  
          <button onclick="location.href='logout.php'"
          class="tokoOpnbtn">logout</button>
        <?php endif; ?>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1): ?>
          <button onclick="openModal('kimono_input.php')" class="tokoOpnbtn">着物を登録する</button>
        <?php endif; ?>
        <button onclick="openModal('kimono_search.php')" class="tokoOpnbtn">着物を検索する</button>
        <button onclick="openModal('calendar.php')" class="tokoOpnbtn">予約カレンダー</button>
        <?php if (!isset($_SESSION['session_id'])): ?>
          <button onclick="location.href='login.php'" class="tokoOpnbtn">トップ画面へ</button>
        <?php endif; ?>
        <?php if (isset($_SESSION['session_id'])): ?>
          <button onclick="location.href='read.php'" class="tokoOpnbtn">おでかけ日記へ</button>
        <?php endif; ?>
        
      </div>
      <div class="a-box">
        <div id="myModal" class="modal">
          <div class="modal-content">
          <span class="close">&times;</span>
          <iframe id="modalContent"></iframe>
          </div>
        </div>
      </div>
      <div class="a-box">
        <h1 class="nikkiP"><legend>着物一覧</legend></h1>
    </div>
      <div class="scrollable">
        <div id="output2">
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
    </script>
</body>

</html>