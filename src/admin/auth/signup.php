<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //ブラウザからのリクエストが、POSTメソッドなのかGETメソッドなのか、スクリプト側で判別
  session_start();
  $email = $_POST["email"];
  $token = $_POST["token"];
  $name = $_POST["name"];
  $password = $_POST["password"];
  $password_confirm = $_POST["password_confirm"];

  if ($password !== $password_confirm) {
    $message = "パスワードが一致しません";
  } else {
    $pdo = new PDO('mysql:host=db;dbname=posse', 'root', 'root');
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(); //PDOオブジェクトでデータベースからデータを取り出した際にデフォルトの配列の形式を指定

    $sql = "SELECT * FROM user_invitations WHERE token = :token AND user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':token', $token);
    $stmt->bindValue(':user_id', $user["id"]);
    $stmt->execute();
    $user_invitation = $stmt->fetch();

    $diff = (new DateTime())->diff(new DateTime($user_invitation["invited_at"])); //DateTimeで現在時刻を取得、diffメソッドを使って$user_invitation["invited_at"]で指定した日付との日にちの差を得る
    $is_expired = $diff->days >= 1; //年月を含めて日数の差を算出し、その値が1以上の時に 'true' を$is_expiredに入れる
    if ($is_expired) {
      $message = "招待期限が切れています。管理者に連絡してください。";
    } else {
      $is_activated = !is_null($user_invitation["activated_at"]); //指定した変数がnullではない時 'true' を$is_activatedの値として入れる
      if ($is_activated) {
        $message = "既に認証済みです。";
      } else {
        try {
          $pdo->beginTransaction(); //トランザクション（「全て登録できる」か「全て登録できない」かのどちらかにしてくれる。中途半端な処理を防ぐ）を開始する。オートコミットがオフになる

          $sql = "UPDATE users SET name = :name, password = :password WHERE id = :id";
          $stmt = $pdo->prepare($sql);
          $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT)); //同じパスワードを毎回異なるハッシュ値に変換し、':password' の値として入れる  //PASSWORD_DEFAULTはbcryptアルゴリズムを使用し、パスワードハッシュを生成。この際に新たに強力なアルゴリズムがphpに追加された時に自動的にそれを使ってくれる
          $stmt->bindValue(':name', $name);
          $stmt->bindValue(':id', $user["id"]);
          $result = $stmt->execute();

          $sql = "UPDATE user_invitations SET activated_at = :activated_at WHERE user_id = :user_id";
          $stmt = $pdo->prepare($sql);
          $stmt->bindValue(':user_id', $user["id"]);
          $stmt->bindValue(':activated_at', (new DateTime())->format('Y-m-d H:i:s'));
          $result = $stmt->execute();

          $pdo->commit(); //エラーがなければ変更をコミットする

          $_SESSION['id'] = $user["id"]; // $_SESSION(セッション変数)の登録
          $_SESSION['message'] = "ユーザー登録に成功しました";
          header('Location: /admin/index.php');
        } catch (PDOException $e) {
          $pdo->rollBack(); //失敗時にデータを元の形に戻す
          $message = $e->getMessage();
        }
      }
    }
  }
} else { //ブラウザからのリクエストがPOSTでなかった場合（つまりはGET）
  session_start();
  $token = isset($_GET['token']) ? $_GET['token'] : null; //$_GET['token']に値がセットされている場合は$tokenにその値を入れ、ない場合はnullを入れる
  $email = isset($_GET['email']) ? $_GET['email'] : null;

  // if (is_null($token) || is_null($email)) { //$tokenと$emailのどちらかがnullか判断
  //   header('Location: /'); //Errorページに送る
  //   // exit(); //いらない...?
  // }

  // if (isset($_SESSION["id"])) {
  //   header('Location: /admin/index.php');
  //   // exit(); //いらない...?
  // }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE ユーザー登録</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="../../assets/styles/common.css">
  <link rel="stylesheet" href="../../assets/styles/auth.css">
  <!-- google fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
  <header>
    <div>POSSE</div>
  </header>
  <div class="wrapper">
    <main>
      <div class="container">
        <h1 class="mb-4">ユーザー登録</h1>
        <?php if (isset($message)) { ?>
          <p><?= $message ?></p>
        <?php } ?>
        <form method="POST">
          <div class="mb-3">
            <label for="name" class="form-label">名前</label>
            <input type="text" name="name" id="name" class="form-control">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="disabled_email" id="email" class="form-control">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password" id="password" class="form-control">
          </div>
          <div class="mb-3">
            <label for="password_confirm" class="form-label">パスワード（確認）</label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
          </div>
          <!-- フォームでhidden属性を利用すればフォームに入力させず何かしらの値を送信することが出来る -->
          <input type="hidden" name="token" id="token" value="<?= $token ?>">
          <input type="hidden" name="token" id="email" value="<?= $email ?>">
          <div class="btn">
            <button type="submit" disabled class="btn submit">登録</button>
          </div>
        </form>
      </div>
    </main>
  </div>
  <script>
    const submitButton = document.querySelector('.btn.submit')
    const inputDoms = Array.from(document.querySelectorAll('.form-control'))
    const password = document.querySelector('#password')
    const passwordConfirm = document.querySelector('#password_confirm')
    inputDoms.forEach(inpuDom => {
      inpuDom.addEventListener('input', event => { //input要素がユーザーの操作によって値が変更されたとき
        const isFilled = inputDoms.filter(d => d.value).length === inputDoms.length //配列inputDomsの要素一個一個にvalueが入ってるか確認し、その検査を通過してできた配列の要素の数がinputDomsの配列の要素数と一致している時に'true'の値をisFilledに入れる
        const isPasswordMatch = password.value === passwordConfirm.value
        submitButton.disabled = !(isFilled && isPasswordMatch) //右辺の値は'true'か'false'のいずれかになる。(isFilled && isPasswordMatch)が成り立たない場合はtrueが入り、ボタンタグは不活性化される
      })
    })
    const signup = async () => { //非同期処理にする
      const res = await fetch('/services/signup.php', { //レスポンスを取得（await で fetch() が完了するまで待つ）
        method: 'PATCH', //データがすでに存在しているものに対して更新
        body: JSON.stringify({ //JSON 文字列に変換
          name: document.querySelector('#name').value,
          email: document.querySelector('#email').value,
          password: document.querySelector('#password').value,
          password_confirm: document.querySelector('#password_confirm').value,
          token: document.querySelector('#token').value,
        }),
        headers: {
          'Accept': 'application/json, */*', //クライアント側がJSONデータを処理できることを表す
          "Content-Type": "application/x-www-form-urlencoded" //実際にどんな形式のデータを送信したかを表す（今回はエンコードされたurlでデータが送受信される）
        },
      });
      const json = await res.json() //格納されていたjsonファイルのデータを取得する（jsonデータを加工するために必要）
      if (res.status === 200) { //ステータスコードが200だった場合 = つまりは成功だった場合
        alert(json["message"])
        location.href = '/admin/index.php'
      } else {
        alert(json["error"]["message"])
      }
    }
  </script>
</body>

</html>