<?php
header('Location: http://localhost:8080/admin/index.php');
require_once '../admin/index.php'; ?>

<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>

  <body>
    <p>ID:<?php $id = $_GET['id'];
        echo $id; ?></p>
  <?php
  $questions = $pdo->query("SELECT image FROM questions WHERE id=$id")->fetchAll(PDO::FETCH_ASSOC);
  var_dump($questions[0]["image"]);
  unlink("../assets/img/quiz/" . $questions[0]["image"]);
  $questions = $pdo->query("DELETE FROM questions WHERE id=$id")->fetchAll(PDO::FETCH_ASSOC);
  $choices = $pdo->query("DELETE FROM choices WHERE question_id=$id")->fetchAll(PDO::FETCH_ASSOC);
  ?>
</body>

</html>