<?php
session_start();
$_SESSION = []; //session_destroy関数だけだと、$_SESSION変数の内容は空にならないから
session_destroy(); //セッションに登録されたデータを全て破棄する

header('Location: /admin/auth/signin.php');
// header('Location: /admin/index.php');
exit;