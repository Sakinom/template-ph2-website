<?php
header('Location: http://localhost:8080/learning_admin/questions.php', true, 307);
require_once '../learning_admin/questions/edit.php';
var_dump($_POST);

?>