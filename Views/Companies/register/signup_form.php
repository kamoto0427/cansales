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

$err = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $company_name = filter_input(INPUT_POST, 'company_name');
  $company_url = filter_input(INPUT_POST, 'company_url');
  $company_tel = filter_input(INPUT_POST, 'company_tel');
  $company_postal = filter_input(INPUT_POST, 'company_postal');
  $company_adress = filter_input(INPUT_POST, 'company_adress');
  $company_email = filter_input(INPUT_POST, 'company_email');
  $company_pass = filter_input(INPUT_POST, 'company_pass');
  $company_passconf = filter_input(INPUT_POST, 'company_passconf');
  $company_role = filter_input(INPUT_POST, 'role');

  // CSRF対策
  $csrf = $_SESSION['csrf_token'];
  $token = filter_input(INPUT_POST, 'csrf_token');
    if(!isset($csrf) || $token !== $csrf) {
    exit('不正なリクエストです。');
  }
  unset($csrf);


  if(empty($company_name)) {
    $err[] = "会社名は必須です。";
  }
  if(empty($company_url)) {
    $err[] = "会社のURLは必須です";
  }
  if(empty($company_tel) || !preg_match("/^[0-9]+$/", $company_tel)) {
    $err[] = "会社の電話番号は必須です。また半角数字で入力してください。";
  }
  if(empty($company_postal) || !preg_match("/^[0-9]+$/", $company_postal)) {
    $err[] = "会社の郵便番号は必須です。また半角数字で入力してください。";
  }
  if(empty($company_adress)) {
    $err[] = "会社の住所は必須です";
  }
  if(empty($company_email) || !filter_var($company_email, FILTER_VALIDATE_EMAIL)) {
    $err[] = "メールアドレスは必須です。また正しいメールアドレスで入力してください。";
  }
  if(!preg_match("/^(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,20}$/i", $company_pass)) {
    $err[] = "パスワードは半角英数字8文字以上20文字以内で入力して下さい。";
  }
  if($company_pass !== $company_passconf) {
    $err[] = "パスワードが一致しません。もう一度確認してください。";
  }

  if(empty($company_role)) {
    $err[] = "サービス提供側かリクエスト側か、どちらか選択してください。";
  }

  if(count($err) === 0) {
    // ユーザを登録する処理
    $hasCreated = Company::createCompany($_POST);
    header('Location: register.php');
    exit();

    if(!$hasCreated) {
      $err[] = "登録に失敗しました！";
    }
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
  <title>会社新規登録画面</title>
</head>
<body>
  <?php include(ROOT_PATH .'Views/common/header.php'); ?>
  <div class="wrapper">
    <div class="container">
      <form action="" method="POST">
        <h1 id="register-title">新規登録</h1>
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
          <label for="company_name" class="form-label">会社名</label>
          <input type="text" class="form-control" id="company_name" name="company_name" value="<?php if(isset($_POST['company_name'])) echo h($company_name) ?>" placeholder="会社名を入力してください。">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_url" class="form-label">会社のURL</label>
          <input type="text" class="form-control" id="company_url" name="company_url" value="<?php if(isset($_POST['company_url'])) echo h($company_url) ?>" placeholder="会社のURLを入力してください。">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_tel" class="form-label">会社の電話番号</label>
          <input type="text" class="form-control" id="company_tel" name="company_tel" value="<?php if(isset($_POST['company_tel'])) echo h($company_tel) ?>" placeholder="会社の電話番号を半角数字で入力してください。例：0399801120">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_postal" class="form-label">会社の郵便番号</label>
          <input type="text" class="form-control" id="company_postal" name="company_postal" value="<?php if(isset($_POST['company_postal'])) echo h($company_postal) ?>" placeholder="会社の郵便番号を半角数字で入力してください。例：1239900">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_adress" class="form-label">会社の住所</label>
          <input type="text" class="form-control" id="company_adress" name="company_adress" value="<?php if(isset($_POST['company_adress'])) echo h($company_adress) ?>" placeholder="会社の住所を入力してください。">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_email" class="form-label">メールアドレス</label>
          <input type="email" class="form-control" id="company_email" name="company_email" value="<?php if(isset($_POST['company_email'])) echo h($company_email) ?>" placeholder="メールアドレスを入力してください。">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_pass" class="form-label">パスワード</label>
          <input type="password" class="form-control" id="company_pass" name="company_pass" value="" placeholder="半角英数字で8文字以上20文字以内で入力してください。">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_passconf" class="form-label">パスワード確認用</label>
          <input type="password" class="form-control" id="company_passconf" name="company_passconf" value="" placeholder="半角英数字で8文字以上20文字以内で入力してください。">
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="role" id="sale_company" value="1">
          <label class="form-check-label" for="flexRadioDefault1">
            営業(サービスを提供する会社)で登録
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="role" id="request_company" value="2">
          <label class="form-check-label" for="flexRadioDefault2">
            リクエスト(サービスを探す会社)で登録
          </label>
        </div>
        <div class="register_btn">
          <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
          <button type="submit" class="btn btn-primary">新規登録する</button>
        </div>
      </form>
    </div>
  </div>
  <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
</body>
</html>