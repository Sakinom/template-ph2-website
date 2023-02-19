<?php

//index.phpへの直リンク禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  //リダイレクト
  header('Location: ./auth/signin.php');
}

$dbn = 'mysql:dbname=posse; host=db; charset=utf8';
$user = 'root';
$password = 'root';

try {

  $pdo = new PDO($dbn, $user, $password);
  // $questions = $pdo->query("INSERT INTO questions (id, content, image, supplement)
  // VALUES ('1', '日本のIT人材が2030年には最大どれくらい不足すると言われているでしょうか？', '', '経済産業省 2019年3月 － IT 人材需給に関する調査')")->fetchAll(PDO::FETCH_ASSOC);
  //   $questions = $pdo->query("INSERT INTO questions (id, content, image, supplement)
  //   VALUES ('2', '既存業界のビジネスと、先進的なテクノロジーを結びつけて生まれた、新しいビジネスのことをなんと言うでしょう？', '', '')")->fetchAll(PDO::FETCH_ASSOC);
  // $questions = $pdo->query("INSERT INTO questions (id, content, image, supplement)
  // VALUES ('3', 'IoTとは何の略でしょう？', '', '')")->fetchAll(PDO::FETCH_ASSOC);
  //   $questions = $pdo->query("INSERT INTO questions (id, content, image, supplement)
  //   VALUES ('4', 'イギリスのコンピューター科学者であるギャビン・ウッド氏が提唱した、ブロックチェーン技術を活用した「次世代分散型インターネット」のことをなんと言うでしょう？
  // ', '', '')")->fetchAll(PDO::FETCH_ASSOC);
  //   $questions = $pdo->query("INSERT INTO questions (id, content, image, supplement)
  //   VALUES ('5', 'イギリスのコンピューター科学者であるギャビン・ウッド氏が提唱した、ブロックチェーン技術を活用した「次世代分散型インターネット」のことをなんと言うでしょう？
  // ', '', 'Society5.0 - 科学技術政策 - 内閣府')")->fetchAll(PDO::FETCH_ASSOC);
  //   $questions = $pdo->query("INSERT INTO questions (id, content, image, supplement)
  //   VALUES ('6', '先進テクノロジー活用企業と出遅れた企業の収益性の差はどれくらいあると言われているでしょうか？
  // ', '', 'Accenture Technology Vision 2021')")->fetchAll(PDO::FETCH_ASSOC);
  $questions = $pdo->query("SELECT * FROM questions")->fetchAll(PDO::FETCH_ASSOC); //SQL文を実行して、結果を$questionsに代入
?>
  <!-- <pre>
  <?php var_dump($questions) ?>
  </pre> -->
<?php

  // foreach ($questions as $question) {
  //   echo $question['id'];
  //   echo $question['content'];
  // }
} catch (PDOException $e) {
  die("接続エラー：{$e->getMessage()}");
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE　管理画面ダッシュボード</title>
  <link rel="stylesheet" href="../assets/styles/common.css">
  <link rel="stylesheet" href="../assets/styles/admin.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
  <script src="../assets/scripts/common.js" defer></script>
</head>

<body>
  <main>
    <div class="question_list">
      <h1>問題一覧</h1>
      <table class="table_questions">
        <thead>
          <tr>
            <th>ID</th>
            <th>問題</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($questions as $question) { ?>
            <tr>
              <td><?= $question['id'] ?></td>
              <td><a href="./questions/edit.php?id=<?= $question['id']; ?>" id="<?= $question['id'] ?>"><?= $question['content'] ?></a></td>
              <td>
                <form method="get" action="../services/delete_question.php">
                  <input id="name" type="text" name="id" value=<?= $question['id'] ?> hidden>
                  <input type="submit" value="削除">
                </form>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="menu">
      <h1>メニュー一覧</h1>
      <form method="GET" action="./questions/create.php">
        <input type="submit" value="問題作成">
      </form>
    </div>
  </main>
</body>

</html>