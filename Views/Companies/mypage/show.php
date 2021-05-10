<?php
// 直リンクの禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: /');
  exit;
}

session_start();
require_once(ROOT_PATH .'/Models/Post.php');
require_once(ROOT_PATH .'/Models/Company.php');
require_once(ROOT_PATH .'/Models/Favorite.php');
require_once(ROOT_PATH .'function.php');
ini_set('display_errors', "On");

// オブジェクトの生成
$obj_p = new Post();
$obj = new Company();
$obj_f = new Favorite();

// idの取得
$id = $_GET['id'];

// 会社の情報を取得
$result = $obj->getCompanyById($id);

// ログインユーザの情報を取得
$company = $_SESSION['login_company'];

// 過去に投稿したリストを取得
$result_p = $obj_p->getListMyShow($id);

// リクエストしたことがあるリスト一覧を取得
$result_r = $obj_p->getRequestMyShow($id);

// お気に入りしたリスト一覧を取得
$result_f = $obj_f->getFavoriteById($_SESSION['login_company']['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="/js/script.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/mypage.css">
  <link rel="stylesheet" href="/css/posts.css">
  <title>マイページ</title>
</head>
<body>
<?php include(ROOT_PATH .'Views/common/header.php'); ?>
  <div class="mypage-show_wrapper">
    <div class="mypage-show_container">
      <ul class="tab-list">
        <?php if($result['id'] === $company['id']): ?>
          <li class="tab-item active">マイページ</li>
        <?php else: ?>
          <li class="tab-item active">会社の詳細</li>
        <?php endif; ?>
        <?php if(($result['role'] == 0) || ($result['role'] == 1)): ?>
          <li class="tab-item">投稿したリスト一覧</li>
        <?php endif; ?>
        <li class="tab-item">リクエストしたリスト一覧</li>
        <li class="tab-item">お気に入り一覧</li>
      </ul>
      <ul class="content-list">
        <li class="content-item show">
          <div class="mypage-show_inner">
            <?php if($result['id'] === $company['id']): ?>
              <h2 id="mypage-show_title">マイページ</h2>
              <div class="mypage-show_contents">
                <div class="contents-list">
                  <p class="list-name">会社名：<?php echo h($company['company_name']) ?></p>
                </div>
                <div class="contents-list">
                  <p class="list-name">会社のURL：<a href="<?php echo h($company['company_url']) ?>"><?php echo h($company['company_url']) ?></a></p>
                </div>
                <div class="contents-list">
                  <p class="list-name">会社の電話番号：<?php echo h($company['tel']) ?></p>
                </div>
                <div class="contents-list">
                  <p class="list-name">会社の郵便番号：<?php echo h($company['postal_code']) ?></p>
                </div>
                <div class="contents-list">
                  <p class="list-name">会社の住所：<?php echo h($company['company_adress']) ?></p>
                </div>
                <div class="contents-free">
                  <p class="list-name">自由記述欄</p>
                </div>
                <div class="free-box">
                  <?php echo nl2br(h($result['free_text'])) ?>
                </div>
              </div>
              <div class="mypage-btn">
                <a class="btn btn-primary btn-lg" id="list-back" href="/Posts/index.php" role="button">リストに戻る</a>
                <a class="btn btn-info btn-lg" href="edit.php?id=<?php echo h($company['id']) ?>" role="button">編集する</a>
              </div>
            <?php  else: ?>
              <h2 id="mypage-show_title">会社の詳細</h2>
              <div class="mypage-show_contents">
                <div class="contents-list">
                  <p class="list-name">会社名：<?php echo h($result['company_name']) ?></p>
                </div>
                <div class="contents-list">
                  <p class="list-name">会社のURL：<a href="<?php echo h($result['company_url']) ?>"><?php echo h($result['company_url']) ?></a></p>
                </div>
                <div class="contents-list">
                  <p class="list-name">会社の電話番号：<?php echo h($result['tel']) ?></p>
                </div>
                <div class="contents-list">
                  <p class="list-name">会社の郵便番号：<?php echo h($result['postal_code']) ?></p>
                </div>
                <div class="contents-list">
                  <p class="list-name">会社の住所：<?php echo h($result['company_adress']) ?></p>
                </div>
                <div class="contents-free">
                  <p class="list-name">自由記述欄</p>
                </div>
                <div class="free-box">
                  <?php echo nl2br(h($result['free_text'])) ?>
                </div>
              </div>
              <div class="mypage-btn">
                <a class="btn btn-primary btn-lg" id="list-back" href="/Posts/index.php" role="button">リストに戻る</a>
              </div>
            <?php endif; ?>
          </div>
        </li>
        <?php if(($result['role'] == 0) || ($result['role'] == 1)): ?>
          <li class="content-item">
            <?php foreach($result_p as $val): ?>
              <div class="lists">
                <div class="l-left-contents">
                  <h5 id="l-left-title"><b><?php echo h($val['title']) ?></b></h5>
                  <p>カテゴリー：<?php echo h($obj_p->setCategoryName($val['category_id'])) ?></p>
                  <div class="list-tags">
                    <p>タグ：<?php echo h($val['tag']) ?></p>
                  </div>
                  <div class="list-detail">
                    <p><?php echo h(mb_strimwidth($val['text'],0,300,'...','UTF-8')) ?><a href="../../Posts/show.php?id=<?php echo h($val['リストID']) ?>">続きを読む</a></p>
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
                    <div class="l-right-contents_bottom">
                      <div class="bottom-btnLists">
                        <a class="btn btn-primary" href="../../Posts/show.php?id=<?php echo h($val['リストID']) ?>" role="button" id="l-showBtn">詳細</a>
                        <?php if($val['企業ID'] === $_SESSION['login_company']['id']): ?>
                          <a class="btn btn-info" href="../../Posts/edit.php?id=<?php echo h($val['リストID']) ?>" role="button">編集</a>
                          <a class="btn btn-success my-3" href="../../request/request.php?id=<?php echo h($val['リストID']) ?>" role="button" >リクエスト</a>
                        <?php else: ?>
                          <a class="btn btn-success" href="../../request/request.php?id=<?php echo h($val['リストID']) ?>" role="button" id="m-show-btn_request">リクエスト</a>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </li>
        <?php endif; ?>
        <li class="content-item">
          <?php foreach($result_r as $row): ?>
            <div class="lists">
              <div class="l-left-contents">
                <h5 id="l-left-title"><b><?php echo h($row['title']) ?></b></h5>
                <p>カテゴリー：<?php echo h($obj_p->setCategoryName($row['category_id'])) ?></p>
                <div class="list-tags">
                  <p>タグ：<?php echo h($row['tag']) ?></p>
                </div>
                <div class="list-detail">
                  <p>最新のリクエスト:<br><?php echo h(mb_strimwidth($row['リクエストテキスト'],0,300,'...','UTF-8')) ?><a href="../../request/request.php?id=<?php echo h($row['リストID']) ?>">続きを読む</a></p>
                </div>
                <div class="created-at">
                  <laber for="created-title">最新のリクエスト：</label>
                  <label for="" class="created-day"><?php echo h($row['最新のリクエスト送信日']) ?></label>
                </div>
              </div>
              <div class="l-right-contents">
                <div class="l-right-contents_top">
                  <div class="service-priceBox">
                    <p id="price-box">サービスの参考価格</p>
                  </div>
                  <div class="service-price">
                    <p id="price">¥<?php echo h(number_format($row['price'])) ?></p>
                  </div>
                  <div class="l-right-contents_bottom">
                    <div class="bottom-btnLists">
                      <a class="btn btn-primary" href="../../Posts/show.php?id=<?php echo h($row['リストID']) ?>" role="button" id="l-showBtn">詳細</a>
                      <a class="btn btn-success" href="../../request/request.php?id=<?php echo h($row['リストID']) ?>" role="button" id="m-show-btn_request">リクエスト</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </li>
        <li class="content-item">
          <?php foreach($result_f as $f): ?>
            リスト名：<a href="../../Posts/show.php?id=<?php echo h($f['p_id']) ?>"><?php echo h($f['title']) ?></a><br><br>
          <?php endforeach; ?>
        </li>
      </ul>
    </div>
  </div>
  <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
</body>
</html>