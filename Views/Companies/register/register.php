<?php
// 直リンクの禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: /');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/register.css">
  <title>会員登録完了画面</title>
</head>
<?php include(ROOT_PATH .'Views/common/header.php'); ?>
<body>
  <div class="r-wrapper">
    <div class="r-container">
      <div class="r-inner">
        <div class="r-contents">
          <h1 id="registered-title">会社情報を登録しました</h1>
          <h6 id="login-need"><font color="red">サービスを利用するにはログインが必要です</font></h6>
            <div class="r-box">
              <div class="box-text">
                <small>ログインしてサービスを利用する</small>
              </div>
              <div class="box-btn">
                <a class="btn btn-primary" href="login_form.php" role="button">ログインする</a>
              </div>
            </div>
            <div class="r-box">
              <div class="box-text">
                <small>ログインせずにホーム画面へ戻る</small>
              </div>
              <div class="box-btn">
                <a class="btn btn-primary" href="../../index.php" role="button">ホームに戻る</a>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
</body>
</html>