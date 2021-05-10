<?php
// 直リンクの禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: /');
  exit;
}

session_start();

require_once(ROOT_PATH .'/Models/Company.php');
require_once(ROOT_PATH .'/Models/Post.php');
require_once(ROOT_PATH .'/Models/Comment.php');
require_once(ROOT_PATH .'function.php');
ini_set('display_errors', "On");

$post_id = $_GET['id'];

// リストの詳細データを取得
$obj = new Post();
$result = $obj->getShowList($post_id);

// コメントのオブジェクト生成
$obj_comment = new Comment();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $msg = $_POST['msg'];
  $company_id = $_SESSION['login_company']['id'];

  // CSRF対策
  $csrf = $_SESSION['csrf_token'];
  $token = filter_input(INPUT_POST, 'csrf_token');
  if(!isset($csrf) || $token !== $csrf) {
    exit();
  }
  unset($csrf);

  // コメントをDBに登録
  $result_msg = $obj_comment->commentInsert($msg, $company_id, $post_id);
}

  // 投稿に紐づいたコメントの取得
  $result_Getmsg = $obj_comment->GetCommentById($post_id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/request.css">

  <title>リクエストページ</title>
</head>
<body>
<?php include(ROOT_PATH .'Views/common/header.php'); ?>
  <div class="req-wrapper">
    <div class="req-container">
      <h3 id="req-title">リスト名：<?php echo h($result['title']) ?></h3>
      <div class="req-contents">
        <table class="req-table">
          <tr>
            <th>サービス提供会社</th>
            <td><?php echo h($result['company_name']) ?></td>
          </tr>
          <tr>
            <th>サービスの参考価格</th>
            <td>¥<?php echo number_format(h($result['price'])) ?></td>
          </tr>
        </table>
        <?php if(isset($result_Getmsg)): ?>
          <?php foreach($result_Getmsg as $row): ?>
            <div class="show-comment">
              <a href=""><?php echo h($row['company_name']) ?></a>
              <p id="comment_field"><?php echo nl2br(h($row['text'])) ?></p>
              <div class="created_deleteBtn">
                <small><?php echo h($row['created_at']) ?></small>
                <?php if($_SESSION['login_company']['id'] === $row['company_id']): ?>
                  <a class="btn btn-danger" href="req_delete.php?id=<?php echo h($row['id']) ?>" role="button" id="comment_delete" onclick="return confirm('本当に削除しますか？')">削除する</a>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif ?>
        <form action="" method="POST">
          <div class="show-request">
            <div class="mb-3">
              <textarea class="form-control" id="msg" rows="10" name="msg"
              placeholder="サービスで疑問に思った点や要望をリクエストしてみましょう。&#13;&#10;現状の課題を具体的に示すと、よりマッチしているサービスかどうかリクエスト先に伝わります。"></textarea>
            </div>
          </div>
          <div class="show-request_btn">
            <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
            <button type="submit" class="btn btn-success" >送信</button>
          </div>
        </form>
        <div class="r-list_backBtn">
          <a class="btn btn-primary" id="r-list_back" href="../Posts/index.php" role="button">リストに戻る</a>
        </div>
      </div>
    </div>
  </div>
  <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
<script type="text/javascript" src="/js/comment.js"></script>
</body>
</html>