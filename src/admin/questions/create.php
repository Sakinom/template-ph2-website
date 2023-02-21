<?php
session_start();

if (empty($_SESSION['id'])) {
  //リダイレクト
  header('Location: ../auth/signin.php');
 }

try {
  $pdo = new PDO('mysql:host=db;dbname=posse;', 'root', 'root');

} catch (PDOException $e) {
  die("接続エラー：{$e->getMessage()}");
}

if (isset($_POST['submit'])) {
  // var_dump($image);
  // var_dump(dirname(__FILE__));
  // var_dump($file);
  var_dump($_FILES['image']['name']);
  // var_dump($_FILES['image']['tmp_name']);
  // if ($_SERVER['REQUEST_METHOD'] === 'POST') {//ファイルが選択されていれば$imageにファイル名を代入
  if (!empty($_FILES['image']['name'])) {//ファイルが選択されていれば$imageにファイル名を代入
    $image = uniqid(mt_rand(), true);//ファイル名をユニーク化
    $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);//アップロードされたファイルの拡張子を取得
    $file = dirname(__FILE__) . '/../../assets/img/quiz/' . $image;
    $sql = "INSERT INTO questions(image) VALUES (:image)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':image', $image, PDO::PARAM_STR);

      move_uploaded_file($_FILES['image']['tmp_name'], $file);//imagesディレクトリにファイル保存
      if (file_exists($file)) {//画像ファイルかのチェック
      // if (file_exists($file) && exif_imagetype('/var/www/html/assets/img/quiz/' . $image)) {//画像ファイルかのチェック
          $message = '画像をアップロードしました';
          // $stmt->execute();
      } else {
          $message = '画像ファイルではありません';
      }
  }else{
    $message = '画像ファイルがありません';
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>問題作成画面</title>
  <link rel="stylesheet" href="../../assets/styles/admin.css">
</head>

<body>
  <main>
    <div class="create_question">
      <form action="../../services/create_question.php" method="POST" enctype="multipart/form-data">
        <div>
          <label for="content">問題文：</label><br>
          <input id="content" type="text" name="content">
        </div>
        <div>
          <label for="choices">選択肢：</label><br>
          <input type="text" name="choices[]" placeholder="選択肢1を入力してください">
          <input type="text" name="choices[]" placeholder="選択肢2を入力してください">
          <input type="text" name="choices[]" placeholder="選択肢3を入力してください">
        </div>
        <div>
          <label for="answer">正解の選択肢：</label><br>
          <div>
            <input id="correctChoice1" type="radio" name="correctChoice" value="0">
            <label for="correctChoice1">選択肢１</label>
          </div>
          <div>
            <input id="correctChoice2" type="radio" name="correctChoice" value="1">
            <label for="correctChoice2">選択肢２</label>
          </div>
          <div>
            <input id="correctChoice3" type="radio" name="correctChoice" value="2">
            <label for="correctChoice3">選択肢３</label>
          </div>
          <div>
            <label for="image">問題の画像：</label><br>
            <!--送信ボタンが押された場合-->
            <?php if (isset($_POST['submit'])) : ?>
              <p><?php echo $message; ?></p>
              <?php else : ?>
                <input id="image" type="file" name="image">
          </div>
          <div>
            <label for="supplement">補足：</label><br>
            <input id="supplement" type="text" name="supplement">
          </div>
          <div>
            <input type="submit" value="確定" name="submit">
          </div>
      </form>
    <?php endif; ?>
    </div>
  </main>
</body>

</html>