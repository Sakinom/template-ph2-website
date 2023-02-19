<?php

try {
  $pdo = new PDO('mysql:dbname=posse;host=db;', 'root', 'root');
  // echo "success";
} catch (PDOException $e) {
  echo "接続エラー：" . $e->getMessage();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE name = :username");
$stmt->bindValue(":username", $_REQUEST["username"]);
$stmt->execute();
$user = $stmt->fetch();
// var_dump($user);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // echo "送信に成功しました";
  if ($_POST["username"] === $user["name"] && $_POST["password"] === $user["password"]) {
    $message = "ログインに成功しました";
  } elseif ($_POST["username"] !== $user["name"]) {
    $message = "IDが存在しません";
  } elseif ($_POST["username"] === $user["name"] && $_POST["password"] !== $user["password"]) {
    $message = "パスワードが正しくありません";
  } else {
    $message = "ログインに失敗しました";
  }
} else {
  // echo "送信に失敗しました";
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
  <link rel="stylesheet" href="../../assets/styles/common.css">
  <link rel="stylesheet" href="../../assets/styles/auth.css">
  <script src="../../assets/scripts/auth.js" defer></script>
</head>

<body>
  <main class="l-main">
    <div class="login_container">
      <div class="login_title">
        <p class="login_title_content">USER LOGIN</p>
      </div>
      <?php if (isset($message)) { ?>
        <p class="message"><?= $message ?></p>
      <?php }; ?>
      <!-- <form action="./login.php" method="post"> -->
      <form action="" method="post">
        <div class="user_input_username">
          <i class="icon_user"></i>
          <input type="text" placeholder="ID" class="username_input linear" name="username">
        </div>
        <div class="user_input_password">
          <i class="icon_password"></i>
          <input type="text" placeholder="Password" class="password_input linear" name="password">
        </div>
        <div class="login_btn">
          <div class="login_btn_container">
            <input type="submit" class="login_btn_content" name="login" value="LOGIN">
          </div>
        </div>
      </form>
      <div class="forgot_btn">
        <p class="forgot_btn_content">Forgot password?</p>
      </div>
    </div>
  </main>
</body>

</html>