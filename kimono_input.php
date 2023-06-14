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
  <title>着物登録</title>
</head>

<body>
  <form action="kimono_create.php" enctype="multipart/form-data" method="POST">
    <fieldset>
      <legend>着物登録画面</legend>
      <a href="kimono_read.php">一覧</a>
      <div class="tokobox">
        <div class="title">
        店舗名：
        </div>
        <div class="input">
        <input type="text" name="gofuku" class="textarea">
        </div>
      </div>
      <div class="tokobox">
        <div class="title">
        メインの模様：
        </div>
        <select name="pattern_id">
          <option value="0">未選択</option>
          <option value="21">麻の葉（あさのは）</option>
          <option value="29">網代（あじろ）</option>
          <option value="26">市松（いちまつ）</option>
          <option value="13">糸巻き（いとまき）</option>
          <option value="40">兎（うさぎ）</option>
          <option value="25">鱗（うろこ）</option>
          <option value="44">エ霞（えがすみ）</option>
          <option value="9">貝桶（かいおけ）</option>
          <option value="27">籠目（かごめ）</option>
          <option value="37">唐草（からくさ）</option>
          <option value="43">観世水（かんぜみず）</option>
          <option value="30">菊（きく）</option>
          <option value="5">亀甲文様（きっこうもんよう）</option>
          <option value="16">桐（きり）</option>
          <option value="4">組紐（くみひも）</option>
          <option value="20">雲取り（くもどり）</option>
          <option value="47">源氏車（げんじぐるま）</option>
          <option value="12">御所車（ごしょぐるま）</option>
          <option value="3">桜（さくら）</option>
          <option value="28">紗綾形（さやがた）</option>
          <option value="15">七宝（しっぽう）</option>
          <option value="1">松竹梅（しょうちくばい）</option>
          <option value="22">青海波（せいがいは）</option>
          <option value="19">扇面（せんめん）</option>
          <option value="45">宝尽くし（たからづくし）</option>
          <option value="6">橘（たちばな）</option>
          <option value="24">立涌（たてわく）</option>
          <option value="42">千鳥（ちどり）</option>
          <option value="18">蝶（ちょう）</option>
          <option value="35">露芝（つゆしば）</option>
          <option value="11">鶴（つる）</option>
          <option value="31">鉄線（てっせん）</option>
          <option value="41">蜻蛉（とんぼ）</option>
          <option value="34">撫子（なでしこ）</option>
          <option value="7">熨斗柄（のしがら）</option>
          <option value="48">瓢箪（ひょうたん）</option>
          <option value="39">ふくら雀（ふくらすずめ）</option>
          <option value="23">藤（ふじ）</option>
          <option value="33">葡萄（ぶどう）</option>
          <option value="38">鳳凰（ほうおう）</option>
          <option value="32">牡丹（ぼたん）</option>
          <option value="17">松皮菱（まつかわびし）</option>
          <option value="2">鞠（まり）</option>
          <option value="36">紅葉（もみじ）</option>
          <option value="46">矢絣（やがすり）</option>
          <option value="14">矢羽根（やばね）</option>
          <option value="8">雪輪（ゆきわ）</option>
          <option value="10">流水文様（りゅうすいもんよう）</option>
        </select>
      </div>
      <div class="tokobox">
        <div class="title">
        着物の色:
        </div>
        <select name="color_id">
          <option value="0">未選択</option>
          <option value="1">朱・赤</option>
          <option value="2">ピンク</option>
          <option value="3">オレンジ</option>
          <option value="4">きいろ</option>
          <option value="5">みどり</option>
          <option value="6">あお、藍</option>
          <option value="7">紫</option>
          <option value="8">茶</option>
          <option value="9">ベージュ</option>
          <option value="10">白</option>
          <option value="11">グレー</option>
          <option value="12">黒</option>
          <option value="13">その他、多彩</option>
        </select>
      </div>
      <div class="tokobox">
        <div class="title">画像：
        </div>
        <div class="input">
        <input type="file" name="img_name" accept=".jpg,.jpeg,.png" required>
        </div>
      </div>
      <div class="tokobox">
        <button class="tokobtn">登録</button>
      </div>
    </fieldset>
  </form>

</body>

</html>