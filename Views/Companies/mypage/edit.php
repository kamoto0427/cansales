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
$id = $_GET['id'];

$obj = new Company();
$result = $obj->getCompanyById($id);

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

  if(count($err) === 0) {
    // ユーザを編集する処理
    $updateCompany = $obj->updateCompany($_POST);
    $_SESSION['list_msg'] = "会社情報を編集しました！";
    header('Location: ../../Posts/index.php');
    exit();

    if(!$updateCompany) {
      $err[] = "編集に失敗しました！";
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
  <title>会社情報の編集</title>
</head>
<body>
<p id="success"><b><?php if(isset($_SESSION['success'])) echo h($_SESSION['success']) ?></b><?php unset($_SESSION['success']) ?></P>
  <?php include(ROOT_PATH .'Views/common/header.php'); ?>
  <div class="wrapper">
    <div class="container">
      <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo h($result['id']) ?>">
        <h1 id="register-title">会社情報の編集</h1>
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
          <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo h($result['company_name']) ?>" placeholder="会社名を入力してください。">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_url" class="form-label">会社のURL</label>
          <input type="text" class="form-control" id="company_url" name="company_url" value="<?php echo h($result['company_url']) ?>" placeholder="会社のURLを入力してください。">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_tel" class="form-label">会社の電話番号</label>
          <input type="text" class="form-control" id="company_tel" name="company_tel" value="<?php echo h($result['tel']) ?>" placeholder="会社の電話番号を半角数字で入力してください。例：0399801120">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_postal" class="form-label">会社の郵便番号</label>
          <input type="text" class="form-control" id="company_postal" name="company_postal" value="<?php echo h($result['postal_code']) ?>" placeholder="会社の郵便番号を半角数字で入力してください。例：1239900">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_adress" class="form-label">会社の住所</label>
          <input type="text" class="form-control" id="company_adress" name="company_adress" value="<?php echo h($result['company_adress']) ?>" placeholder="会社の住所を入力してください。">
        </div>
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="company_email" class="form-label">メールアドレス</label>
          <input type="email" class="form-control" id="company_email" name="company_email" value="<?php echo h($result['email']) ?>" placeholder="メールアドレスを入力してください。">
        </div>
        <div class="mb-3">
          <label for="free_text" class="form-label">自由記述欄(任意)</label>
          <textarea class="form-control" id="free_text" name="free_text" rows="10" placeholder="会社のアピールなど自由に記述してください。"><?php echo h($result['free_text']) ?></textarea>
        </div>
        <div class="register_btn">
          <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
          <button type="submit" class="btn btn-primary">会社の情報を更新する</button>
        </div>
      </form>
    </div>
  </div>
  <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
</body>
</html>