<?php
session_start();
include("functions.php");
check_session_id();

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
    //元の画像を削除するコード（どこかで転けたら作動させない工夫。全部うまく行った時だけ実行）
    // 元の画像を削除
    $old_img_name = $_POST['old_img_name'];
    if ($old_img_name !== "") {
      $old_img_path = $upload . "/" . $old_img_name;
    if (file_exists($old_img_path)) {
        unlink($old_img_path);
        echo "元の画像を削除しました。";
    } else {
        echo "元の画像が見つかりません。";
    }
}

} else {
    echo "画像の保存に失敗しました。";
}

//if文に当てはまらなかった場合の処理
$title = $_POST['title'];
$toko = $_POST['toko'];
$id = $_POST['id'];

$pdo = connect_to_db();

$sql = "UPDATE data_table SET title=:title, toko=:toko, img_name=:img_name, updated_at=now() WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':toko', $toko, PDO::PARAM_STR);
$stmt->bindValue(':img_name', $img_name_new, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:read.php");
exit();
