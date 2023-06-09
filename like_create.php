<?php
// var_dump($_GET);
// exit();

session_start();
include("functions.php");
check_session_id();

if (
  !isset($_GET['user_id']) || $_GET['user_id'] === '' ||
  !isset($_GET['data_id']) || $_GET['data_id'] === ''
) {
  exit('paramError');
}

$user_id = $_GET['user_id'];
$data_id = $_GET['data_id'];

$pdo = connect_to_db();

$sql = 'SELECT COUNT(*) FROM like_table WHERE user_id=:user_id AND data_id=:data_id'; //条件に当てはまるものが何件あるかカウントする

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':data_id', $data_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$like_count = $stmt->fetchColumn();

// var_dump($like_count);
// exit();

if ($like_count !== 0) {
    // いいねされている状態では削除（DELETE）
    $sql = 'DELETE FROM like_table WHERE user_id=:user_id AND data_id=:data_id';
} else {
    //いいねされていない状態では追加（INSERT）
    $sql = 'INSERT INTO like_table(id, user_id, data_id, created_at) VALUES(NULL, :user_id, :data_id, now())';}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':data_id', $data_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:read.php");
exit();
