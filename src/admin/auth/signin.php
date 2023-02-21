<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $pdo = new PDO('mysql:host=db;dbname=posse', 'root', 'root');
  $sql = "SELECT * FROM users WHERE email = :email";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':email', $email);
  $stmt->execute();
  $user = $stmt->fetch();

  if (!$user || !password_verify($password, $user["password"])) { //パスワードがハッシュにマッチするかどうかを調べる password_verify(パスワード,ハッシュ値) かつ $userの中に中身があるかどうか
    $message = "認証情報が正しくありません";
    var_dump($user);
    var_dump($_POST["password"]);
    var_dump($user["password"]);
  } else {
    session_start();
    $_SESSION['id'] = $user["id"];
    $_SESSION['name'] = $user["name"];
    $message = "ログインに成功しました";

    header('Location: ../index.php');
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE ログイン</title>
  <link rel="stylesheet" href="../../assets/styles/common.css">
  <link rel="stylesheet" href="../../assets/styles/auth.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
</head>
<body>
  <header>
    <div>POSSE</div>
  </header>
  <div class="wrapper">
    <main>
      <div class="container">
        <h1 class="mb-4">ログイン</h1>
        <?php if (isset($message)) {?>
          <p><?= $message?></p>
        <?php } ?>
        <form action="" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" class="email form-control" id="email">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="text" name="password" class="form-control" id="password">
          </div>
          <div class="login_btn">
            <button type="submit" disabled class="btn submit">ログイン</button>
          </div>
        </form>
      </div>
    </main>
  </div>
  <script>
    const EMAIL_REGEX = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/ //メールアドレスのパターン 正規表現
    const submitButton = document.querySelector('.btn.submit')
    const emailInput = document.querySelector('.email')
    const inputDoms = Array.from(document.querySelectorAll('.form-control'))
    inputDoms.forEach(inpuDom => {
      inpuDom.addEventListener('input', event => {
        const isFilled = inputDoms.filter(d => d.value).length === inputDoms.length
        submitButton.disabled = !(isFilled && EMAIL_REGEX.test(emailInput.value))
      })
    })
  </script>
</body>
</html>