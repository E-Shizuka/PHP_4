<?php
session_start();
include("functions.php");

// //POSTデータ確認
// var_dump($_POST);
// exit();

if (
  !isset($_POST['name']) || $_POST['name'] === '' ||
  !isset($_POST['number']) || $_POST['number'] === '' ||
  !isset($_POST['email']) || $_POST['email'] === '' ||
  !isset($_POST['day']) || $_POST['day'] === ''
) {
  exit('データが不足しています。');
}

//if文に当てはまらなかった場合の処理
$name = $_POST['name'];
$number = $_POST['number'];
$email = $_POST['email'];
$day = $_POST['day'];

// DB接続
$pdo = connect_to_db();

// 「dbError:...」が表示されたらdb接続でエラーが発生していることがわかる．

// SQL作成&実行
$sql = 'INSERT INTO reservation_table (id, name, number, email, day, created_at) VALUES (NULL,  :name, :number, :email, :day, now())';

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':number', $number, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':day', $day, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQLが正常に実行された後の処理
header('Location:calendar.php');
exit();



?>