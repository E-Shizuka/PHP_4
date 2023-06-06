<?php

function connect_to_db()
{
  $dbn = 'mysql:dbname=service;charset=utf8mb4;port=3306;host=localhost';
  $user = 'root';
  $pwd = '';

  try {
    return new PDO($dbn, $user, $pwd);
  } catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
}

// ログイン状態のチェック関数
function check_session_id()
{
  if (!isset($_SESSION["session_id"]) ||
    //セッションidがない
    $_SESSION["session_id"] !== session_id()
    //セッションidが登録されているものと異なる
    ) {
    header('Location:login.php');
    //ログイン画面へ移動させる
    exit();
  } else {
    session_regenerate_id(true);
    //idを作り直す。（定期的に変更した方が良いため）
    $_SESSION["session_id"] = session_id();
  }
}
