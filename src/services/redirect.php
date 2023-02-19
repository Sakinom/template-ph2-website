<?php 
header('Location: http://localhost:8080/admin/index.php', true, 307);
require_once '../admin/questions/edit.php';

// $stmt = $pdo->prepare("SELECT * FROM questions WHERE id = :id");
// $stmt->bindValue(":id", $_REQUEST["id"]);
// $stmt->execute();
// $question = $stmt->fetch();
// // var_dump($question);

// $stmt = $pdo->prepare("SELECT * FROM choices WHERE question_id = :id");
// $stmt->bindValue(":id", $_REQUEST["id"]);
// $stmt->execute();
// $choices = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $stmt = $pdo->prepare($sql);
// $result = $stmt->execute($params);

// $sql = "DELETE FROM choices WHERE question_id = :question_id ";
//     $stmt = $pdo->prepare($sql);
//     $stmt->bindValue(":question_id", $_POST["question_id"]);
//     $stmt->execute();

//     $stmt = $pdo->prepare("INSERT INTO choices(name, valid, question_id) VALUES(:name, :valid, :question_id)");
//     for ($i = 0; $i < count($_POST["choices"]); $i++) {
//       $stmt->execute([
//         "name" => $_POST["choices"][$i],
//         "valid" => (int)$_POST['correctChoice'] === $i ? 1 : 0,
//         "question_id" => $_POST["question_id"]
//       ]);
//     }
