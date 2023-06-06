<?php
session_start();
include("functions.php");
check_session_id();

// //POSTデータ確認
// var_dump($_POST);
// exit();

if (
  !isset($_POST['title']) || $_POST['title'] === '' ||
  !isset($_POST['toko']) || $_POST['toko'] === '' ||
  !isset($_FILES['img_name']) || $_FILES['img_name']['name'] === ''
) {
  exit('データが不足しています。');
}

$img_name = $_FILES["img_name"]["name"];
$img_tmp = $_FILES["img_name"]["tmp_name"];
 // 一時的なファイルのパス

// 画像を保存するディレクトリのパス
$upload = "./img";

// ファイル名を一意に生成
$uniqid = uniqid();
$img_name_new = $uniqid . "_" . $img_name;

// 画像を移動して保存
if (move_uploaded_file($img_tmp, $upload . "/" . $img_name_new)) {
    echo "画像の保存に成功しました。";
} else {
    echo "画像の保存に失敗しました。";
}

//if文に当てはまらなかった場合の処理
$title = $_POST['title'];
$toko = $_POST['toko'];
$username = $_SESSION['username'];

// DB接続処理

// 各種項目設定
$dbn ='mysql:dbname=service;charset=utf8mb4;port=3306;host=localhost';
//'mysql:dbname=YOUR_DB_NAME;データベース名のみ更新
$user = 'root';
$pwd = '';
//デプロイする時にuserとpwdを記載

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// 「dbError:...」が表示されたらdb接続でエラーが発生していることがわかる．

// SQL作成&実行
$sql = 'INSERT INTO data_table (id, username, title,toko, img_name, created_at, updated_at) VALUES (NULL,  :username, :title, :toko,  :img_name, now(), now())';

$stmt = $pdo->prepare($sql);

//$todo等直接変数を入れると悪意のある攻撃を受ける可能性があるのでバインド変数を使う
// バインド変数を設定（関数の数だけ設定が必要）
$stmt->bindValue(':username', $_SESSION['username'], PDO::PARAM_STR);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':toko', $toko, PDO::PARAM_STR);
$stmt->bindValue(':img_name', $img_name_new, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQLが正常に実行された後の処理
header('Location:input.php');
exit();
