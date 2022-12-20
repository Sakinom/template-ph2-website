<?php
$dbn = 'mysql:dbname=posse; host=db; charset=utf8';
$user = 'root';
$password = 'root';

try {
  $pdo = new PDO($dbn, $user, $password);

  $questions = $pdo->query("SELECT * FROM questions")->fetchAll(PDO::FETCH_ASSOC);
  $choices = $pdo->query("SELECT * FROM choices")->fetchAll(PDO::FETCH_ASSOC);

  foreach ($choices as $key => $choice) {
    $index = array_search($choice["question_id"], array_column($questions, 'id'));
    $questions[$index]["choices"][] = $choice;
  }
} catch (PDOException $e) {
  die("接続エラー：{$e->getMessage()}");
} finally {
  $db = null;
}
?>