<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/posts.css">
  <title>ホーム画面</title>
</head>
<body>
<?php include(ROOT_PATH .'Views/common/header.php'); ?>
  <div class="wrapper">
    <!-- ホームトップ -->
    <img src="/img/トップ.jpg" alt="サイトトップ画像" width="100%" height="680">
    <div class="service-title">
      <h3 id="s-title">マッチしたサービスを探せる</h4>
      <h1 id="s-title_bottom">リクエスト型「<font color="red">逆営業</font>」アプリ</h1>
      <a class="btn btn-primary" href="../Companies/register/signup_form.php" role="button" id="top-btn">会員登録してリクエストする</a>
    </div>
    <!-- リクエストとは？ -->
    <div class="what-req">
      <h2 id="req-title">リクエストとは？</h2>
      <div class="req-contents">
        <p id="req-text">「営業してほしい！」と依頼する機能です。<br>
        投稿されたリストの中でマッチするサービスがあれば、リクエストをして営業を受けましょう。<br>
        従来のように「営業される」を待つではなく、"自分"で逆に営業を受けにいきましょう。</p>
        </p>
      </div>
    </div>
    <!-- サービスを利用する流れ -->
    <div class="service-flow">
      <h2 id="s-flow_title">サービスを利用する流れ</h2>
      <!-- 営業会社 -->
      <h4>-営業会社(サービス提供)の場合-</h4>
      <div class="s-flow_boxes">
        <div class="s-flow_box">
          <p class="s-flow_box-title">ステップ①</p>
          <p class="s-flow_box-text">会員登録したら、<br>まずはリストを投稿！</p>
        </div>
        <div class="s-flow_box">
          <p class="s-flow_box-title">ステップ②</p>
          <p class="s-flow_box-text">リストを具体的に書き、リクエストをもらおう！</p>
        </div>
        <div class="s-flow_box">
          <p class="s-flow_box-title">ステップ③</p>
          <p class="s-flow_box-text">リクエストがきたら、<br>マッチング!<br>営業してみよう！</p>
        </div>
      </div>
      <!-- リクエスト会社 -->
      <h4>-リクエスト会社(サービスを探す)の場合-</h4>
      <div class="s-flow_boxes">
        <div class="s-flow_box">
          <p class="s-flow_box-title">ステップ①</p>
          <p class="s-flow_box-text">会員登録したら、まずはリストをチェック！</p>
        </div>
        <div class="s-flow_box">
          <p class="s-flow_box-title">ステップ②</p>
          <p class="s-flow_box-text">マッチしたリストがあれば、リクエストして営業を受けてみよう！</p>
        </div>
        <div class="s-flow_box">
          <p class="s-flow_box-title">ステップ③</p>
          <p class="s-flow_box-text">タグ機能を実装し、マッチするサービスを探す手間も削減</p>
        </div>
      </div>
    </div>

    <!-- リストのサンプル -->
    <div class="lists-sample">
      <div class="lists-sample_inner">
        <h2 id="l-title">リストのサンプル</h2>
        <div class="lists">
          <div class="l-left-contents">
            <a href="#" id="list-company">株式会社サンプル</a>
            <h5 id="l-left-title"><strong>月額59800円でハイスペック人材集結！就職イベントが熱い</strong></h5>
            <div class="list-tags">
              #求人 #低予算 #人材育成
            </div>
            <div class="list-detail">
              <small>優秀な人材を獲得するのに苦労しますよね。「なかなか企業にマッチする人材が見つからない」「効率よく人材を獲得したい」と感じませんか？そこでおすすめなのが、就職イベント！しかもただの就職イベントではありません。事前審査に合格した方のみ参加できる"ハイスペック人材"のみ厳選しています。月額59800円で利用できるサービス...<a href="#">続きを読む</a></small>
            </div>
            <div class="created-at">
              <laber for="created-title">作成日：</label>
              <label for="" class="created-day">2021年4月12日</label>
            </div>
          </div>
          <div class="l-right-contents">
            <div class="l-right-contents_top">
              <div class="service-priceBox">
                <p id="price-box">サービスの参考価格</p>
              </div>
              <div class="service-price">
                <p id="price">10,000円</p>
              </div>
              <div class="favorite-btn">
                <i class="far fa-star">お気に入り</i>
              </div>
            </div>
            <div class="l-right-contents_bottom">
              <div class="bottom-btnLists">
                <a class="btn btn-primary" href="#" role="button" id="l-showBtn">詳細</a>
                <a class="btn btn-success" href="#" role="button">リクエスト</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- アコーディオン -->
    <div class="question-wrapper">
      <h2 id="often-question">よくある質問</h2>
      <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              リクエストとはなんですか？
            </button>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              リクエストとは、「営業してほしい！」と依頼する機能です。投稿されたリストの中でマッチするサービスがあれば、リクエストをして営業を受けましょう。従来のように「営業される」を待つではなく、"自分"で逆に営業を受けにいくスタイルが当たり前です。
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
              リストを投稿、または閲覧するにはどうすればいいですか？
            </button>
          </h2>
          <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              会員登録し、ログインしましょう。ログインすれば、リストの投稿、閲覧、リクエスト機能が利用できます。
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
              マッチするサービスを見つけるにはどうしたらいいですか？
            </button>
          </h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              カテゴリーやタグで条件検索しましょう。
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $Path = "./"; include(dirname(__FILE__).'/common/footer.php'); ?>
  </div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
</body>
</html>