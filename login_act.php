<!-- ログインチェック関数を入れちゃだめ
ログインしようとしているのにログイン画面に戻される -->

<?php
session_start();
include('functions.php');
// データ受け取り
// var_dump($_POST);
// exit();

$username = $_POST['username'];
$password = $_POST['password'];

// DB接続
$pdo = connect_to_db();

// SQL実行
//全ての条件満たすデータを抽出する。削除したアカウントのログインを弾くため、nullのもののみ抽出
$sql='SELECT * FROM users_table WHERE username=:username AND password=:password AND deleted_at IS NULL';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// ユーザ有無で条件分岐
$user = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($user);
// exit();

if (!$user) {
  echo "<p>ログイン情報に誤りがあります</p>";
  echo "<a href=login.php>ログイン</a>";
  //情報が一致しなかった時
  exit();
} else {
  $_SESSION = array();
  $_SESSION['session_id'] = session_id();
  $_SESSION['is_admin'] = $user['is_admin'];
  $_SESSION['username'] = $user['username'];
  header("Location:read.php");
  exit();
}