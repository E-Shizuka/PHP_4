<?php
session_start();
include("functions.php");

// //POSTデータ確認
// var_dump($_POST);
// exit();


if (
  !isset($_POST['gofuku']) || $_POST['gofuku'] === '' ||
  !isset($_POST['pattern_id']) || $_POST['pattern_id'] === '' ||
  !isset($_POST['color_id']) || $_POST['color_id'] === ''||
  !isset($_FILES['img_name']) || $_FILES['img_name']['name'] === ''
  ) {
    exit('paramError');
  }

$img_name = $_FILES["img_name"]["name"];
$img_tmp = $_FILES["img_name"]["tmp_name"];
 // 一時的なファイルのパス

// 画像を保存するディレクトリのパス
$upload = "./kimono_img";

// ファイル名を一意に生成
$uniqid = uniqid();
$img_name_new = $upload . "/" . $uniqid . "_" . $img_name;

// 画像を移動して保存
if (move_uploaded_file($img_tmp,  $img_name_new)) {
    echo "画像の保存に成功しました。";
} else {
    echo "画像の保存に失敗しました。";
}

//if文に当てはまらなかった場合の処理
  $gofuku = $_POST['gofuku'];
  $pattern_id = $_POST['pattern_id'];
  $color_id = $_POST['color_id'];

$pdo = connect_to_db();

$sql = 'INSERT INTO kimono_search(id, gofuku, pattern_id, color_id, img_name, created_at) VALUES(NULL, :gofuku, :pattern_id, :color_id, :img_name, now())';

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':gofuku', $gofuku, PDO::PARAM_STR);
$stmt->bindValue(':pattern_id', $pattern_id, PDO::PARAM_STR);
$stmt->bindValue(':color_id', $color_id, PDO::PARAM_STR);
$stmt->bindValue(':img_name', $img_name_new, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:kimono_input.php");
exit();
