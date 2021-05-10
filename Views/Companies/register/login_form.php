<?php
// 直リンクの禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: /');
  exit;
}

session_start();
require_once(ROOT_PATH .'/Models/Company.php');
require_once(ROOT_PATH .'/function.php');
ini_set('display_errors', "On");

$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);

$err = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $email = filter_input(INPUT_POST, 'email');
  $password = filter_input(INPUT_POST, 'password');

  // CSRF対策
  $csrf = $_SESSION['csrf_token'];
  $token = filter_input(INPUT_POST, 'csrf_token');
    if(!isset($csrf) || $token !== $csrf) {
    exit('不正なリクエストです。');
  }
  unset($csrf);

  if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err[] = "メールアドレスは必須です。また正しいメールアドレスで入力してください。";
  }
  if(!$password = filter_input(INPUT_POST, 'password')) {
    $err[] = "パスワードを記入してください。";
  }
  // ログイン成功時の処理
  $result = Company::login($email, $password);
  if($result == true) {
    $_SESSION['msg'] = "";
    header('Location: login.php');
    exit;
  } else {
    $err[] = $_SESSION['msg'];
  }
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
  <title>ログイン画面</title>
</head>
<body>
<?php include(ROOT_PATH .'Views/common/header.php'); ?>
<?php if(isset($login_err)): ?>
<div class="alert alert-danger" role="alert">
  <p id="login_name"><?php echo $login_err; ?></P>
</div>
<?php endif; ?>
  <div class="l-wrapper">
    <div class="l-container">
      <form action="" method="POST">
        <h1 id="login-title">ログイン</h1>
        <?php if(count($err) > 0): ?>
          <div class="alert alert-danger" role="alert">
          <?php foreach($err as $e): ?>
            <ul>
              <li><?php echo $e ?></li>
            </ul>
            <?php endforeach ?>
          </div>
        <?php endif; ?>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="email" class="form-label">メールアドレス</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="メールアドレスを入力してください。">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="pass" class="form-label">パスワード</label>
          <input type="password" class="form-control" id="password" name="password" name="password" placeholder="半角英数字で8文字以上">
        </div>
        <div class="login_btn">
          <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
          <button type="submit" class="btn btn-primary">ログインする</button>
        </div>
        <div class="l-link">
          <div class="link-home">
            <a href="../../index.php">ホーム画面へ戻る</a>
          </div>
          <div class="link-register">
            <a href="signup_form.php">新規登録はこちら</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
</body>
</html>