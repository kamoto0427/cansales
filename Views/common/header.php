<?php
require_once(ROOT_PATH .'/Models/Company.php');
require_once(ROOT_PATH .'function.php');

$obj_c = new Company();

// ログインユーザの取得
if(isset($_SESSION['login_company']['id'])) {
  $company = $obj_c->getCompanyById($_SESSION['login_company']['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/common.css">
  <title>ヘッダー</title>
</head>
<body>
  <header>
    <div class="hr-wrapper">
      <div class="hr-container">
        <div class="hr-logo">
          <a href="/"><i class="fas fa-copyright" id="c-logo"></i></a>
        </div>
        <div class="hr-title">
          <a href="/"><h3>Can!セールス</h2></a>
          <h7>リクエスト型「<font color="red">逆営業</font>」アプリ</h5>
        </div>
      </div>
    </div>
    <div class="hl-wrapper">
      <div class="hl-container">
        <?php if(isset($_SESSION['login_company'])): ?>
          <a class="btn btn-outline-primary" href="/Posts/index.php" role="button" id="login_btn">リスト一覧</a>
          <?php if(($company['role']) == 0 || ($company['role']) == 1): ?>
            <a class="btn btn-outline-primary" href="/Posts/post.php" role="button" id="login_btn">リスト投稿</a>
          <?php endif; ?>
          <a class="btn btn-outline-primary" href="/Companies/mypage/show.php?id=<?php echo h($_SESSION['login_company']['id']) ?>" role="button" id="login_btn">マイページ</a>
          <a class="btn btn-outline-primary" href="/Companies/register/logout.php" role="button">ログアウト</a>
        <?php else: ?>
          <a class="btn btn-outline-primary" href="/Companies/register/login_form.php" role="button" id="login_btn">ログイン</a>
          <a class="btn btn-outline-primary" href="/Companies/register/signup_form.php" role="button">新規登録</a>
        <?php endif; ?>
      </div>
    </div>
  </header>
</body>
</html>