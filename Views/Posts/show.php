<?php
// 直リンクの禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: /');
  exit;
}

session_start();

require_once(ROOT_PATH .'/Models/Company.php');
require_once(ROOT_PATH .'/Models/Post.php');
require_once(ROOT_PATH .'function.php');
ini_set('display_errors', "On");


$id = $_GET['id'];
if(empty($id)) {
  exit('リストIDが不正です。');
}

// リストの詳細データを取得
$obj = new Post();
$result = $obj->getShowList($id);

$obj_c = new Company();
// ログインユーザの取得
$company = $obj_c->getCompanyById($_SESSION['login_company']['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/posts.css">
  <title>リスト詳細</title>
</head>
<body>
<?php include(ROOT_PATH .'Views/common/header.php'); ?>
  <div class="show-wrapper">
    <div class="show-container">
      <h3 id="show-title"><?php echo h($result['title']) ?></h3>
      <div class="show-img">
        <img src="<?php echo "/"."{$result['img']}" ?>" class="img-fluid" alt="...">
      </div>
      <table class="show-table">
        <tr>
          <th>会社名</th>
          <td><?php echo h($result['company_name']) ?></td>
        </tr>
        <tr>
          <th>カテゴリー</th>
          <td><?php echo $obj->setCategoryName(h($result['category_id'])) ?></td>
        </tr>
        <tr>
          <th>タグ</th>
          <td><?php echo h($result['tag']) ?></td>
        </tr>
        <tr>
          <th>サービスの参考価格</th>
          <td>¥<?php echo number_format(h($result['price'])) ?></td>
        </tr>
        <tr>
          <th>作成日</th>
          <td><?php echo h($result['created_at']) ?></td>
        </tr>
      </table>
      <div class="show-textAria">
        <?php echo nl2br(h($result['text'])) ?>
      </div>
      <div class="show-btn_contents">
        <?php if($result['company_id'] === $_SESSION['login_company']['id']): ?>
          <a class="btn btn-info" href="edit.php?id=<?php echo h($result['id']) ?>" role="button" id="show-btn_edit">編集する</a>
          <a class="btn btn-danger" href="delete.php?id=<?php echo h($result['id']) ?>" role="button" id="show-btn_delete" onclick="return confirm('本当に削除しますか？')">削除する</a>
        <?php else: ?>
          <a class="btn btn-primary" href="index.php" role="button" id="show-btn_listBack">リストに戻る</a>
          <?php if(($company['role']) == 1 || ($company['role']) == 2): ?>
            <a class="btn btn-success" href="../request/request.php?id=<?php echo h($result['id']) ?>" role="button" id="show-btn_request">リクエスト</a>
          <?php endif; ?>
          <?php if($company['role'] == 0): ?>
            <a class="btn btn-danger" href="delete.php?id=<?php echo h($val['id']) ?>" role="button" id="show-btn_delete" onclick="return confirm('本当に削除しますか？')">削除する</a>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
</body>
</html>