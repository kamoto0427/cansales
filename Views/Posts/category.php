<?php
// 直リンクの禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: /');
  exit;
}

session_start();
require_once(ROOT_PATH .'/Models/Post.php');
require_once(ROOT_PATH .'/Models/Favorite.php');
require_once(ROOT_PATH .'function.php');
ini_set('display_errors', "On");

// オブジェクトの生成
$obj = new Post();
$obj_f = new Favorite();

$id = $_GET['id'];
// カテゴリーごとのリストの表示
$result = $obj->GetCategoryViewById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src=" https://code.jquery.com/jquery-3.4.1.min.js "></script>
  <script src="/js/favorite.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/posts.css">
  <title>リスト一覧画面</title>
</head>
<body>
<p id="list_success"><?php if(isset($_SESSION['list_msg'])) echo h($_SESSION['list_msg']) ?></P>
<?php include(ROOT_PATH .'Views/common/header.php'); ?>
<p id="login_name"><?php echo h($_SESSION['login_company']['company_name']) ?>さん、こんにちは！</P>
  <div class="list-wrapper">
    <div class="list-container">
      <div class="sidebar">
        <h6 id="s-category">カテゴリー</h6>
        <div class="list-group">
          <a href="index.php" class="list-group-item list-group-item-action">リストトップ</a>
          <a href="category.php?id=1" class="list-group-item list-group-item-action">求人</a>
          <a href="category.php?id=2" class="list-group-item list-group-item-action">人材育成・研修</a>
          <a href="category.php?id=3" class="list-group-item list-group-item-action">集客・マーケティング</a>
          <a href="category.php?id=4" class="list-group-item list-group-item-action">Webサイト制作</a>
          <a href="category.php?id=5" class="list-group-item list-group-item-action">Webコンテンツ制作</a>
          <a href="category.php?id=6" class="list-group-item list-group-item-action">イラスト</a>
          <a href="category.php?id=7" class="list-group-item list-group-item-action">営業・コールセンター代行</a>
          <a href="category.php?id=8" class="list-group-item list-group-item-action">ビジネス相談・経営コンサル</a>
          <a href="category.php?id=9" class="list-group-item list-group-item-action">士業(税理士・行政書士など)</a>
          <a href="category.php?id=10" class="list-group-item list-group-item-action">翻訳・語学</a>
          <a href="category.php?id=11" class="list-group-item list-group-item-action">クリーニング</a>
          <a href="category.php?id=12" class="list-group-item list-group-item-action">音楽・ナレーション</a>
          <a href="category.php?id=13" class="list-group-item list-group-item-action">その他</a>
        </div>
      </div>
      <div class="main">
        <div class="main-container">
          <div class="search-box">
            <form action="search.php" method="post">
              <input type="search" name="search" value="" placeholder="キーワード">
              <input type="submit" name="btn_search" value="検索">
            </form>
          </div>
          <?php foreach($result as $val): ?>
            <div class="lists">
              <div class="l-left-contents">
                <a href="../Companies/mypage/show.php?id=<?php echo h($val['company_id']) ?>" id="list-company"><?php echo h($val['企業名']) ?></a>
                <h5 id="l-left-title"><b><?php echo h($val['title']) ?></b></h5>
                <p>カテゴリー：<?php echo h($obj->setCategoryName($val['category_id'])) ?></p>
                <div class="list-tags">
                  <p>タグ：<?php echo h($val['tag']) ?></p>
                </div>
                <div class="list-detail">
                  <p><?php echo h(mb_strimwidth($val['text'],0,300,'...','UTF-8')) ?><a href="show.php?id=<?php echo h($val['リストID']) ?>">続きを読む</a></p>
                </div>
                <div class="created-at">
                  <laber for="created-title">作成日：</label>
                  <label for="" class="created-day"><?php echo h($val['created_at']) ?></label>
                </div>
              </div>
              <div class="l-right-contents">
                <div class="l-right-contents_top">
                  <div class="service-priceBox">
                    <p id="price-box">サービスの参考価格</p>
                  </div>
                  <div class="service-price">
                    <p id="price">¥<?php echo h(number_format($val['price'])) ?></p>
                  </div>
                  <form class="favorite_count" action="" method="POST">
                    <button type="button" name="favorite" class="favorite_btn" data-post_id="<?php echo h($val['リストID']) ?>" data-c_id="<?php echo h($_SESSION['login_company']['id']) ?>">
                      <?php if ($obj_f->check_favolite_duplicate($_SESSION['login_company']['id'], $val['リストID'])): ?>
                        <i class="fas fa-star">お気に入り解除</i>
                      <?php else: ?>
                        <i class="far fa-star">お気に入り</i>
                      <?php endif; ?>
                    </button>
                  </form>
                </div>
                <div class="l-right-contents_bottom">
                  <div class="bottom-btnLists">
                    <a class="btn btn-primary" href="show.php?id=<?php echo h($val['リストID']) ?>" role="button" id="l-showBtn">詳細</a>
                    <?php if(($company['role']) == 1 || ($company['role']) == 2): ?>
                      <a class="btn btn-success" href="../request/request.php?id=<?php echo h($val['id']) ?>" role="button">リクエスト</a>
                    <?php endif; ?>
                    <?php if($company['role'] == 0): ?>
                      <a class="btn btn-danger" href="delete.php?id=<?php echo h($val['id']) ?>" role="button" id="delete_btn" onclick="return confirm('本当に削除しますか？')">削除する</a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  </div>
<?php include(ROOT_PATH .'Views/common/footer.php'); ?>
</body>
</html>