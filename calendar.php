<?php
session_start();
include("functions.php");

//予約された日の情報を取得する関数
function getreservation(){
    $pdo = connect_to_db();
    $sql = 'SELECT * FROM reservation_table';
    $stmt = $pdo->prepare($sql);
    
    try {
        $status = $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
        exit();
    }
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // var_dump($result);
    // exit();
    
    //各日付の予約を入れるため配列
    $reservation_day = array();
    
    foreach ($result as $record) {
        //予約された全ての日付情報を文字列として格納
        $day_record = strtotime((string) $record['day']);
        $reservation_day[date('Y-m-j', $day_record)]= true;
    }
    //日付の古い順に並び替え
    ksort($reservation_day);
    // var_dump($reservation_day);
    // exit();
    return $reservation_day;
}

$reservation_day = getreservation();


function reservation($date, $reservation_day, $holidayData){
    //カレンダーの日付と予約された日付を照合する関数
    $today = date('Y-m-d'); // 日付のフォーマットを修正
    if(array_key_exists($date,$reservation_day)){
        //もし"カレンダーの日付"と"予約された日"が一致すれば以下を実行する
        $reservation_day = "<br/>"."<span class='green'>"."予約できません"."</span>";
        return $reservation_day;
    }

    $dayOfWeek = date('w', strtotime($date)); // 日付の曜日を取得
    
    // 土曜日または日曜日の場合、予約できないメッセージを表示
    if ($dayOfWeek == 6 || $dayOfWeek == 0) {
        $reservation_day = "";
        // $reservation_day = "<br/>" . "<span>" . "予約できません" . "</span>";
        return $reservation_day;
    } elseif (strtotime($date) > strtotime($today)) {
        $reservation_day = "<br/>" . "<button class=\"button4\" onclick=\"getReservationInfo('$date')\">" . "予約する" . "</button>";
        return $reservation_day;
    } else {
        $reservation_day = "";
        return $reservation_day;
    }
    
    // $reservation_day = "<br/>" . "<button class=\"button3\" onclick=\"location.href='reservation.php'\">" . "予約する" . "</button>";
    
    // 祝日データをチェックし、祝日の場合も予約できないメッセージを表示
    foreach ($holidayData as $holiday) {
        if ($date == $holiday['holiday']) {
            $reservation_day = "<br/>" . "<span>" . "予約できません" . "</span>";
            return $reservation_day;
        }
    }
}

//祝日のデータを読み込む
$holidayFile = 'data/syukujitsu.txt';

// var_dump($holidayFile);
// exit();

//ファイルを行ごとの配列に読み込む
$holidays = file($holidayFile, FILE_IGNORE_NEW_LINES); 

$holidayData = array();
foreach ($holidays as $holiday) {
    $parts = explode(",", $holiday);
    $date = date('Y-m-j', strtotime($parts[0]));
    $name = $parts[1];
    $holidayData[] = [
        'holiday' => $date,
        'holidayname' => $name
    ];
}

// echo"<pre>";
// var_dump($holidayData);
// echo"</pre>";
// exit();


//タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

//前月・次月リンクが選択された場合は、GETパラメーターから年月を取得
if(isset($_GET['ym'])){ 
    $ym = $_GET['ym'];
}else{
    //今月の年月を表示
    $ym = date('Y-m');
}

//タイムスタンプ（どの時刻を基準にするか）を作成し、フォーマットをチェックする
//strtotime('Y-m-01')
$timestamp = strtotime($ym . '-01'); 
if($timestamp === false){//エラー対策
    //falseが返ってきた時は、現在の年月・タイムスタンプを取得
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

//今月の日付 フォーマット
$today = date('Y-m-j');

//カレンダーのタイトルを作成 2020年10月
$html_title = date('Y年n月', $timestamp);//date(表示する内容,基準)

//前月・次月の年月を取得
//strtotime(,基準)
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

//該当月の日数を取得
$day_count = date('t', $timestamp);

//１日が何曜日か
$youbi = date('w', $timestamp);

//カレンダー作成の準備
$weeks = [];
$week = '';

//第１週目：空のセルを追加
//str_repeat(文字列, 反復回数)
$week .= str_repeat('<td></td>', $youbi);

for($day = 1; $day <= $day_count; $day++, $youbi++){
    
    $date = $ym . '-' . $day; //日付のフォーマット
    $reservation = reservation(date("Y-m-d", strtotime($date)), $reservation_day, $holidayData);
    if ($today == $date) {
    $week .= '<td class="today">' . $day;
    } elseif (in_array($date, array_column($holidayData, 'holiday'))) {
    $index = array_search($date, array_column($holidayData, 'holiday'));
    $name = $holidayData[$index]['holidayname'];
    $week .= '<td class="shukujitsu">' . $day . '<br>' . $name;
    } else {
    $week .= '<td>' . $day . $reservation;
    }
    
    if($youbi % 7 == 6 || $day == $day_count){
        //週終わり、月終わりの場合
        //余りが6のとき、または土曜日
        if($day == $day_count){//月の最終日、空セルを追加
            $week .= str_repeat('<td></td>', 6 - ($youbi % 7));
        }
        
        $week .= '</td>';
        $weeks[] = '<tr>' . $week . '</tr>'; //weeks配列にtrと$weekを追加
        
        $week = '';//weekをリセット
        
    }

    if ($day == $day_count) {
        break; // $day_count を超えたらループを終了
    }
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>PHPカレンダー</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link
    href="https://fonts.googleapis.com/earlyaccess/kokoro.css"
    rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
  <link rel="stylesheet" type="text/css" href="css/sanitize.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <!--  -->
</head>
<body>
    <div class="all">
        <div class="a-box">
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1): ?>
          <button onclick="location.href='calendar_read.php'" class="tokoOpnbtn">予約確認</button>
        <?php endif; ?>
            <?php if (!isset($_SESSION['session_id'])): ?>
            <button onclick="location.href='login.php'" class="tokoOpnbtn">トップ画面へ</button>
            <?php endif; ?>
            <?php if (isset($_SESSION['session_id'])): ?>
            <button onclick="location.href='read.php'" class="tokoOpnbtn">おでかけ日記へ</button>
            <?php endif; ?>
            <button onclick="location.href='kimono_read.php'"
        class="tokoOpnbtn">着物一覧へ</button>
        </div>
        <div class="container">
            <h2>予約入力画面</h2>
            <p>予約時間はいずれも15:00〜16:30とさせていただきます。</p>
            <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a>  <?php echo $html_title; ?>  <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
            <table class="table table-bordered">
                <tr>
                    <th>日</th>
                    <th>月</th>
                    <th>火</th>
                    <th>水</th>
                    <th>木</th>
                    <th>金</th>
                    <th>土</th>
            
                <?php
                    foreach ($weeks as $week) {
                        echo $week;
                    }
                ?>
            </table>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    function getReservationInfo(date) {
  // フォームを作成
  const form = $('<form></form>');
  form.attr('method', 'POST');
  form.attr('action', 'reservation.php');

  // 日付情報を作成してフォームに追加
  const dateInput = $('<input>');
  dateInput.attr('type', 'hidden');
  dateInput.attr('name', 'date');
  dateInput.val(date);
  form.append(dateInput);

  // フォームをページに追加して送信
  $('body').append(form);
  form.submit();

}
    </script>

</body>
</html>