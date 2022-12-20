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

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ITクイズ | POSSE 初めてのWeb制作</title>
  <link rel="stylesheet" href="./assets/styles/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
  <header class="l-header p-header">
    <div class="p-header_logo"><img src="../assets/img/logo.svg" alt="POSSE"></div>
    <div class="hamburger-menu">
      <input type="checkbox" id="menu-btn-check">
      <label for="menu-btn-check" class="menu-btn"><span></span></label>
      <div class="menu-content">
        <ul>
          <li>
            <a href="../index.html" class="menu-item_1">POSSEとは</a>
          </li>
          <li>
            <a href="./quizpage.php" class="menu-item_2">クイズ</a>
          </li>
        </ul>
      </div>
    </div>

    <nav class="p-header_nav">
      <ul class="p-header_nav_list">
        <li class="p-header_nav_item">
          <a href="../index.html" class="p-header_nav_item_link">トップページ</a>
        </li>
        <li class="p-header_nav_item">
          <a href="./quizpage.php" class="p-header_nav_item_link">クイズ</a>
        </li>
      </ul>
    </nav>
    <ul class="p-header_sns p-sns">
      <li class="p-sns_item">
        <a href="https://twitter.com/posse_program" target="_blank" rel="noopener noreferrer" class="p-sns_item_link" aria-label="Twitter">
          <i class="u-icon_twitter"></i>
        </a>
      </li>
      <li class="p-sns_item">
        <a href="http://www.instagram.com/posse_programming/" target="_blank" rel="noopener noreferrer" class="p-sns_item_link" aria-label="instagram">
          <i class="u-icon_instagram"></i>
        </a>
      </li>
    </ul>
  </header>

  <main class="l-main">
    <section class="p-hero p-quiz-hero">
      <div class="l-container">
        <h1 class="p-hero_title">
          <span class="p-hero_title_label">POSSE課題</span>
          <span class="p-hero_title_inline">ITクイズ</span>
        </h1>
      </div>
    </section>

    <div class="p-quiz-container l-container" id="js-quizContainer">
      <?php for ($i = 0; $i < count($questions); $i++) { ?>
        <h2 class="p-quiz-box_question_title">
          <span class="p-quiz-box_label">Q<?= $i + 1 ?></span>
          <span class="p-quiz-box_question_title_text"><?= $questions[$i]["content"]; ?></span>
        </h2>
        <figure class="p-quiz-box_question_image">
          <img src="../assets/img/quiz/img-quiz0<?= $i + 1 ?>.png" alt="">
        </figure>
        <div class="p-quiz-box_answer">
          <span class="p-quiz-box_label p-quiz-box_label--accent">A</span>
          <ul class="p-quiz-box_answer_list">
            <?php for ($j = 0; $j < count($choices); $j++) { ?>
              <li class="p-quiz-box_answer_item">
                <button class="p-quiz-box_answer_button js-answer" data-answer="${answerIndex}">
                  <?php
                  if ($choices[$j]["question_id"] == $questions[$i]["id"]) {
                    echo $choices[$j]["name"];
                  }
                  ?><i class="u-icon_arrow"></i>
                </button>
              </li>
            <?php } ?>

          </ul>
          <div class="p-quiz-box_answer_correct js-answerBox">
            <p class="p-quiz-box_answer_correct_title js-answerTitle"></p>
            <p class="p-quiz-box_answer_correct_content">
              <span class="p-quiz-box_answer_correct_content_label">A</span>
              <span class="js-answerText"></span>
            </p>
          </div>
        </div>

      <?php } ?>
    </div>
  </main>

  <div class="p-line">
    <div class="l-container">
      <div class="p-line_body">
        <div class="p-line_body_inner">
          <h2 class="p-heading -light p-line_title"><i class="u-icon_line"></i>POSSE 公式LINE</h2>
          <div class="p-line_content">
            <p>公式LINEにてご質問を随時受け付けております。<br>詳細やPOSSE最新情報につきましては、公式LINEにてお知らせ致しますので<br>下記ボタンより友達追加をお願いします！</p>
          </div>
          <div class="p-line_footer">
            <a href="https://line.me/R/ti/p/@651htnqp?from=page" target="_blank" rel="noopener noreferrer" class="p-line_button">LINE追加<i class="u-icon_link"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="l-footer p-footer">
    <div class="p-fixedLine" id="js-fixedLine">
      <a href="http://line.me/R/ti/p/@651htnqp?from=page" target="_blank" rel="noopener noreferrer" class="p-fixedLine_link" id="js-lineLink">
        <i class="u-icon_line"></i>
        <p class="p-fixedLine_line_text" id="js-iconLine">POSSE公式LINEで<br>最新情報をGET！</p>
        <i class="u-icon_link"></i>
      </a>
      <div class="p-fixedIcon" id="js-fixedIcon"></div>
    </div>
    <div class="l-footer_inner">
      <div class="p-footer_siteinfo">
        <span class="p-footer_logo">
          <img src="../assets/img/logo.svg" alt="POSSE">
        </span>
        <a href="http://posse-ap.com/" target="_blank" rel="noopener noreferrer" class="p-footer_siteinfo_link">POSSE公式サイト</a>
        <i class="p-footer_icon_link"></i>
      </div>
      <div class="p-footer_sns">
        <ul class="p-sns_list p-footer_sns_list">
          <li class="p-sns_item">
            <a href="http://twitter.com/posse_program" target="_blank" rel="noopener noreferrer" class="p-sns_item_link" aria-label="Twitter">
              <i class="u-icon_twitter"></i>
            </a>
          </li>
          <li class="p-sns_item">
            <a href="http://www.instagram.com/posse_programming/" target="_blank" rel="noopener noreferrer" class="p-sns_item_link" aria-label="instagram">
              <i class="u-icon_instagram"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="p-footer_copyright">
      <small lang="en">©︎2022 POSSE</small>
    </div>
  </footer>
</body>
<!-- <script src="quiz.js"></script> -->
<!-- <script src="quiz-sub.js"></script> -->
<!-- <script src="../toppage/toppage.js"></script> -->

</html>