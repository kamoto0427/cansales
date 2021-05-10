<?php
// 直リンクの禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: /');
  exit;
}

require_once(ROOT_PATH .'/Models/Comment.php');
ini_set('display_errors', "On");

$id = $_GET['id'];

$obj = new Comment();
$result = $obj->CommentDelete($id);

$back = $_SERVER['HTTP_REFERER'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/register.css">
  <title>Document</title>
</head>
<body>
  <?php include(ROOT_PATH .'Views/common/header.php'); ?>
    <h1 id="done-title"><font color="red">リクエストを削除しました</font></h1>
    <div class="loginDone-logo">
      <i class="fas fa-trash-alt" id="check"></i>
    </div>
    <p>リクエストの削除が実行されました。</p>
    <div class="list-btn">
      <a class="btn btn-outline-success" href="<?php echo $back; ?>" role="button" id="list">リクエストに戻る</a>
    </div>
    <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
  </body>
</html>
