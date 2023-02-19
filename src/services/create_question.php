<?php
// 入力後はindex.phpにリダイレクト
header('Location: .././admin/index.php');
require_once '../admin/questions/create.php';

try {
  $pdo = new PDO('mysql:host=db;dbname=posse', 'root', 'root');
} catch (PDOException $e) {
  die("接続エラー：{$e->getMessage()}");
}

  // INSERT命令の準備
  $stt = $pdo->prepare('INSERT INTO questions(content, image, supplement) VALUES(:content, :image, :supplement)');
  // INSERT命令にポストデータの内容をセット
  $stt->bindValue(':content', $_POST['content']);
  // $stt->bindValue(':answer', $_POST['answer']);
  $stt->bindValue(':image', $image);
  $stt->bindValue(':supplement', $_POST['supplement']);
  // INSERT命令を実行
  $stt->execute();
  // 登録したデータのIDを取得
  $lastInsertId = $pdo->lastInsertId();

  $stt = $pdo->prepare('INSERT INTO choices(question_id, name, valid) VALUES(:question_id, :name, :valid)');
  for($i = 0; $i < count($_POST["choices"]); $i++){
    // var_dump($_POST["choices"][$i]);
    // var_dump($_POST['correctChoice'] == $i ? 1 : 0);
    $stt->execute([
      "question_id" => $lastInsertId,
      "name" => $_POST["choices"][$i],
      "valid" => (int)$_POST['correctChoice'] === $i ? 1 : 0,
    ]);
  }
?>

  <img src="../assets/img/quiz/<?= $image; ?>" width="300" height="300">