<?php
// if (empty($_SERVER["HTTP_REFERER"])) {
//   //リダイレクト
//   header('Location: ../auth/signin.php');
//  }

try {
  $pdo = new PDO('mysql:host=db;dbname=posse;', 'root', 'root');
} catch (PDOException $e) {
  die("接続エラー：{$e->getMessage()}");
}

$stmt = $pdo->prepare("SELECT * FROM questions WHERE id = :id");
$stmt->bindValue(":id", $_REQUEST["id"]);
$stmt->execute();
$question = $stmt->fetch();
// var_dump($question);

$stmt = $pdo->prepare("SELECT * FROM choices WHERE question_id = :id");
$stmt->bindValue(":id", $_REQUEST["id"]);
$stmt->execute();
$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
if (isset($_POST['edit'])) {
  $params = [
    "content" => $_POST["content"],
    "supplement" => $_POST["supplement"],
    "id" => $_POST["question_id"],
  ];
  $set_query = "SET content = :content, supplement = :supplement";
  if ($_FILES["image"]["tmp_name"] !== "") {
    $set_query .= ", image = :image";
    $params["image"] = "";
  }

  $sql = "UPDATE questions $set_query WHERE id = :id";

  if(isset($params["image"])) {
    $image_name = uniqid(mt_rand(), true) . '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);
    $image_path = dirname(__FILE__) . '/../../assets/img/quiz/' . $image_name;
    move_uploaded_file(
      $_FILES['image']['tmp_name'],
      $image_path
    );
    $params["image"] = $image_name;
  }else{
    echo 'empty';
    unlink("../../assets/img/quiz/" . $question["image"]);
  }

  $stmt = $pdo->prepare($sql);
  $result = $stmt->execute($params);

  $sql = "DELETE FROM choices WHERE question_id = :question_id ";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":question_id", $_POST["question_id"]);
      $stmt->execute();

      $stmt = $pdo->prepare("INSERT INTO choices(name, valid, question_id) VALUES(:name, :valid, :question_id)");
      for ($i = 0; $i < count($_POST["choices"]); $i++) {
        $stmt->execute([
          "name" => $_POST["choices"][$i],
          "valid" => (int)$_POST['correctChoice'] === $i ? 1 : 0,
          "question_id" => $_POST["question_id"]
        ]);
      }
}else{
  // echo "failed";
}
// echo '<pre>';
// var_dump($choices);
// echo '</pre>';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>問題編集画面</title>
  <!-- <link rel="stylesheet" href="../../assets/styles/common.css"> -->
  <link rel="stylesheet" href="../../assets/styles/admin.css">
</head>

<body>
  <!-- <?= $_GET['id'] ?> -->
  <main>
    <div class="create_question">
      <form action="../../services/redirect.php" method="post" enctype="multipart/form-data">
        <div>
          <label for="content">問題文：</label><br>
          <input id="content" type="text" name="content" value="<?= $question['content'] ?>">
        </div>
        <div>
          <label for="choices">選択肢：</label><br>
          <input type="text" name="choices[]" placeholder="選択肢1を入力してください" value="<?= $choices[0]['name'] ?>">
          <input type="text" name="choices[]" placeholder="選択肢2を入力してください" value="<?= $choices[1]['name'] ?>">
          <input type="text" name="choices[]" placeholder="選択肢3を入力してください" value="<?= $choices[2]['name'] ?>">
        </div>
        <div>
          <label for="answer">正解の選択肢：</label><br>
          <div>
            <input id="correctChoice1" type="radio" name="correctChoice" value="0" <?= $choices[0]['valid'] === 1 ? 'checked' : ''; ?>>
            <label for="correctChoice1">選択肢１</label>
          </div>
          <div>
            <input id="correctChoice2" type="radio" name="correctChoice" value="1" <?= $choices[1]['valid'] === 1 ? 'checked' : ''; ?>>
            <label for="correctChoice2">選択肢２</label>
          </div>
          <div>
            <input id="correctChoice3" type="radio" name="correctChoice" value="2" <?= $choices[2]['valid'] === 1 ? 'checked' : ''; ?>>
            <label for="correctChoice3">選択肢３</label>
          </div>
          <div>
            <label for="image">問題の画像：</label><br>
            <!--送信ボタンが押された場合-->
              <input id="image" type="file" name="image">
          </div>
          <div>
            <label for="supplement">補足：</label><br>
            <input id="supplement" type="text" name="supplement" value="<?= $question["supplement"] ?>">
          </div>
          <div>
            <input type="hidden" name="question_id" value="<?= $question["id"]?>">
            <input type="submit" value="更新" name="edit">
          </div>
      </form>
    </div>
  </main>

</body>

</html>