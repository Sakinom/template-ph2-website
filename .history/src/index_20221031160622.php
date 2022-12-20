<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE 初めてのWeb制作</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="./assets/styles/common.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <script src="../assets/scripts/common.js" defer></script>
</head>

<body>
  <?php include(dirname(_FILE_) . '/components/header.php'); ?>
  <main class="l-main">
    <section class="p-top-hero">
      <div class="p-top-hero_inner">
        <div class="p-top-hero_body">
          <h1 class="p-top-hero_body_title">学生プログラミングコミュニティ POSSE（ポッセ）</h1>
          <span class="p-top-hero_body_catchcopy">自分史上最高<br>を仲間と。</span>
        </div>
        <picture class="p-top-hero_image">
          <img src="./assets/img/img-hero.jpg" alt="">
        </picture>
        <div class="p-top-hero_scroll">Scroll Down</div>
      </div>
    </section>
    <!-- /.p-top-hero -->

    <div class="p-top-container">
      <section class="l-section p-top-about">
        <div class="l-container">
          <h2 class="p-heading">
            POSSEとは<span class="p-heading_caption" lang="en" aria-hidden="true">About POSSE</span>
          </h2>
          <div class="p-top-about_body">
            <picture class="p-top-about_image">
              <img src="./assets/img/img-about.jpg" alt="POSSEメンバー集合写真">
            </picture>
            <div class="p-top-about_content">
              <p>
                学生プログラミングコミュニティ「POSSE(ポッセ)」は、人格とプログラミング、二つの面での成長をスローガンに活動しており、大学生だけが集まって学びを深めるコミュニティです。<br>プログラミングだけではありません。オフラインでのイベントや、旅行など様々な企画を行っています！<br>それらを通じて、夏休みの大半をPOSSEで出来た仲間と過ごす人もたくさんいるほどメンバーとの仲が深まります。
              </p>
            </div>
          </div>
        </div>
      </section>
      <!-- /.l-section p-top-about -->
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
            <a href="https://line.me/R/ti/p/@651htnqp?from=page" target="_blank" rel="noopener noreferrer"
              class="p-line_button">LINE追加<i class="u-icon_link"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include(dirname(_FILE_) . '/components/footer.php'); ?>
  
</body>

</html>
