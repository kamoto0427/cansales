<?php
// 直リンクの禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: /');
  exit;
}

session_start();

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
  <title>ログイン完了画面</title>
</head>
<body>
<?php include(ROOT_PATH .'Views/common/header.php'); ?>
  <h1 id="done-title">ログイン完了</h1>
  <div class="loginDone-logo">
    <i class="far fa-check-circle" id="check"></i>
  </div>
  <p>ログインが完了しました！</p>
  <div class="list-btn">
    <a class="btn btn-outline-success" href="../../Posts/index.php" role="button" id="list">リスト一覧へ</a>
  </div>
  <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
</body>
</html>