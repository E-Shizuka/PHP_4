<?php
// DB接続したいファイル（todo_create.php, todo_read.php, など）
include('functions.php');
$pdo = connect_to_db();

// var_dump($_POST);
// exit();

////全部1つのテーブルにして出力するsql
// $sql = 'SELECT kimono_search.*, pattern_table.pattern, color_table.color FROM kimono_search LEFT OUTER JOIN (SELECT id, pattern FROM kimono_pattern) AS pattern_table ON kimono_search.pattern_id = pattern_table.id LEFT OUTER JOIN (SELECT id, color FROM kimono_color) AS color_table ON kimono_search.color_id = color_table.id ORDER BY kimono_search.created_at DESC';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 入力された検索キーワードを取得
  $gofuku = $_POST['gofuku'];
  $pattern_id = isset($_POST['pattern_id']) ? $_POST['pattern_id'] : '';
  $color_id = isset($_POST['color_id']) ? $_POST['color_id'] : '';

  // SQLクエリを構築
  $sql = 'SELECT kimono_search.*, pattern_table.pattern, color_table.color FROM kimono_search LEFT OUTER JOIN (SELECT id, pattern FROM kimono_pattern) AS pattern_table ON kimono_search.pattern_id = pattern_table.id LEFT OUTER JOIN (SELECT id, color FROM kimono_color) AS color_table ON kimono_search.color_id = color_table.id WHERE 1=1'; // 初期クエリ

  if (!empty($gofuku)) {
    $sql .= " AND gofuku LIKE '%$gofuku%'";
  }
  if (!empty($pattern_id)) {
    $sql .= " AND pattern_id LIKE '$pattern_id'";
  }
  if (!empty($color_id)) {
    $sql .= " AND color_id LIKE '$color_id'";
  }


  $sql .= ' ORDER BY kimono_search.created_at DESC';

  $pdo->prepare($sql);
  $stmt = $pdo->prepare($sql);
  
  try {
  $stmt->execute();
} catch (PDOException $e) {
  echo "SQL Error: " . $e->getMessage();
}
  
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
if (empty($result)) {
  $output .= "
    <div id=\"output2\">
    <div class=\"toko\">
      <p>該当する商品はありませんでした。</p>
    </div>
    </div>
  ";
} else {
  foreach ($result as $record) {
    $output .= "
      <div id=\"output2\">
      <div class=\"toko\">
        <div class=\"pictureArea\"><img src=\"/service2/{$record["img_name"]}\" ></div>
        <div class=\"textDataArea\"><h3>{$record['pattern']}</h3>
        <p>{$record['gofuku']}</p></div>
      </div>
      </div>
    ";
  }
}
    
    // <td>
    //   <a href='kimono_edit.php?id={$record["id"]}'>edit</a>
    // </td>
    // <td>
    //   <a href='kimono_delete.php?id={$record["id"]}'>delete</a>
    // </td>

}


//編集画面や削除するためにリンクをつける。その際にidを取得する

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
  <title>着物検索</title>
</head>

<body>
  <fieldset>
    <legend>着物検索結果</legend>
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
</body>

</html>