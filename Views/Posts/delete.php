<?php
// 直リンクの禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: /');
  exit;
}

require_once(ROOT_PATH .'/Models/Post.php');
ini_set('display_errors', "On");

$id = $_GET['id'];

$obj = new Post();
$result = $obj->deleteList($id);
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
  <title>リスト削除</title>
</head>
<body>
<?php include(ROOT_PATH .'Views/common/header.php'); ?>
  <h1 id="done-title"><font color="red">リストを削除しました</font></h1>
  <div class="loginDone-logo">
    <i class="fas fa-trash-alt" id="check"></i>
  </div>
  <p>リストの削除が実行されました。</p>
  <div class="list-btn">
    <a class="btn btn-outline-success" href="index.php" role="button" id="list">リスト一覧へ</a>
  </div>
  <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
</body>
</html>
</body>