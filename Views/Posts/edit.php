<?php
// 直リンクの禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: /');
  exit;
}

session_start();
require_once(ROOT_PATH .'/Models/Post.php');
require_once(ROOT_PATH .'function.php');
ini_set('display_errors', "On");
$obj = new Post();

$id = $_GET['id'];
if(empty($id)) {
  exit('リストIDが不正です。');
}

// ログインしているユーザid
$company_id = $_SESSION['login_company']['id'];

// リストの詳細データを取得
$result = $obj->getShowList($id);


$err = [];

  if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $title = filter_input(INPUT_POST, 'title');
      $text = filter_input(INPUT_POST, 'text');
      $tags = filter_input(INPUT_POST, 'tags');
      $category = filter_input(INPUT_POST, 'category');
      $price = filter_input(INPUT_POST, 'price');

      // CSRF対策
      $csrf = $_SESSION['csrf_token'];
      $token = filter_input(INPUT_POST, 'csrf_token');
        if(!isset($csrf) || $token !== $csrf) {
        exit('不正なリクエストです。');
      }
      unset($csrf);
      
      // 画像
      $img = basename($_FILES['img']['name']);
      $img_err = $_FILES['img']['error'];
      $imgsize = $_FILES['img']['size'];
      $tmp_path = $_FILES['img']['tmp_name'];
      $upload_dir = 'img/';
      $save_filename = date('Ymdhis').$img;
      $save_path = $upload_dir.$save_filename;
    
      // タイトル、詳細、カテゴリー、参考価格のバリデーション
      if(empty($title) || mb_strlen($title) > 30) {
        $err['title'] = "タイトルは必須です。また、30文字以内で入力してください。";
      }
      if(empty($tags)) {
        $err['tags'] = "タグを選択してください";
      }
      if(empty($text) || mb_strlen($text) > 3000) {
        $err['text'] = "サービスの詳細は必須です。また、3000文字以内で入力してください。";
      }
      if(empty($category)) {
        $err['category'] = "カテゴリーを以下のセレクトボックスから選択してください";
      }
      if(empty($price) || !preg_match("/^[0-9]+$/", $price)) {
        $err['price'] = "サービスの参考価格を半角数字で入力してください。";
      }
    
      // 画像ファイルのバリデーション
      // ①画像ファイルがあるか
      if(is_uploaded_file($tmp_path)) {
        // 画像データを移動
        move_uploaded_file($tmp_path, $save_path);
      } else {
        $err['img'] = "画像を保存できませんでした。";
      }
    
      // ②拡張子は画像形式か
      $allow_ext = array('jpg', 'jpeg', 'png');
      $file_ext = pathinfo($img, PATHINFO_EXTENSION);
    
      if(!in_array(strtolower($file_ext), $allow_ext)) {
        $err['img'] = "画像ファイルはjpg,jpeg,png形式にしてください。";
      }
    
      // ③ファイルのサイズが1MB未満か
      if($imgsize > 1048576 || $img_err == 2) {
        $err['img'] = "ファイルのサイズは1MB未満にしてください。";
      }
    
      // エラーがなければ、DBにデータを保存し、リスト一覧にページ遷移
      if(count($err) === 0) {
        $j_tags = implode('/', array_column(json_decode($_POST['tags']), 'value'));
        $update = $obj->updateList($id, $_POST, $save_path, $j_tags);
        $_SESSION['list_msg'] = "リストの編集に成功しました!";
        header('Location: index.php');
        exit;
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/posts.css">
  <title>リスト編集画面</title>
</head>
<body>
<?php include(ROOT_PATH .'Views/common/header.php'); ?>
  <div class="p-wrapper">
    <div class="p-container">
      <h2 id="p-title">リストを編集する</h2>
      <form action="" method="POST" enctype="multipart/form-data" id="p-form">
        <!-- タイトル -->
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="title" class="form-label">タイトル</label>
          <?php if(isset($err['title'])): ?>
            <p class="err"><font color="red"><?php echo $err['title'] ?></font></p>
          <?php endif; ?>
          <input type="text" class="form-control" id="title" name="title" value="<?php echo h($result['title']) ?>" placeholder="タイトルを入力してください(30文字以内)">
        </div>
        <!-- タグ -->
        <div class="tag-lebel">
          <label for="kome"><font color="red">*</font></label>
          <label for="tag" class="form-label">タグを新たに選択してください(最低1つは選択しましょう)</label>
          <?php if(isset($err['tags'])): ?>
            <p class="err"><font color="red"><?php echo $err['tags'] ?></font></p>
          <?php endif; ?>
        </div>
        <div class="mb-3 tag-form">
          <div class="tags_current">現在のタグ：<b><?php echo h($result['tag']) ?></b></div>
          <input name="tags" class='tag_field' placeholder="ここをクリック" value="">
        </div>
        <br>
        <!-- サービス詳細 -->
        <div class="mb-3">
          <label for="kome"><font color="red">*</font></label>
          <label for="contents" class="form-label">詳細</label>
          <?php if(isset($err['text'])): ?>
            <p class="err"><font color="red"><?php echo $err['text'] ?></font></p>
          <?php endif; ?>
          <textarea class="form-control" id="contents" name="text" rows="20" placeholder="サービスの内容、利用者のメリット、アピールしたい実績などを3000文字以内で具体的に書いてください。具体的でわかりやすいほど、リストを見た企業がリクエストをしてくれる確率がアップします。"><?php echo h($result['text']) ?></textarea>
        </div>
        <!-- カテゴリー -->
        <h6 id="p-category"><label for="kome"><font color="red">*</font></label>カテゴリーを選択してください</h6>
        <?php if(isset($err['category'])): ?>
            <p class="err_one"><font color="red"><?php echo $err['category'] ?></font></p>
          <?php endif; ?>
        <select class="form-select" id="category-select" name="category">
          <option selected><?php echo h($obj->setCategoryName($result['category_id'])) ?></option>
          <option value="1">求人</option>
          <option value="2">人材育成・研修</option>
          <option value="3">集客・マーケティング</option>
          <option value="4">Webサイト制作</option>
          <option value="5">Webコンテンツ制作</option>
          <option value="6">イラスト</option>
          <option value="7">営業・コールセンター代行</option>
          <option value="8">ビジネス相談・経営コンサル</option>
          <option value="9">士業(税理士・行政書士など)</option>
          <option value="10">翻訳・語学</option>
          <option value="11">クリーニング</option>
          <option value="12">音楽・ナレーション</option>
          <option value="13">その他</option>
        </select>
        <!-- サービスの参考価格 -->
        <h6 id="p-price"><label for="kome"><font color="red">*</font></label>サービスを利用する際の参考価格</h6>
        <?php if(isset($err['price'])): ?>
            <p class="err_one"><font color="red"><?php echo $err['price'] ?></font></p>
          <?php endif; ?>
        <div class="mb-3">
          <input type="text" class="form-control" id="p-price_form" name="price" placeholder="29800" value="<?php echo h($result['price']) ?>">
        </div>
        <!-- 画像 -->
        <h6 id="p-image"><label for="kome"><font color="red">*</font></label>画像を追加してください</h6>
        <?php if(isset($err['img'])): ?>
            <p class="err_one"><font color="red"><?php echo $err['img'] ?></font></p>
          <?php endif; ?>
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
        <input type="file" class="form-control" id="p-image_upload" name="img" value="">
        <!-- リスト投稿ボタン -->
        <div class="p-btn">
          <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
          <button type="submit" class="btn btn-primary" id="p-btn_btn" name="b">リストを更新する</button>
        </div>
      </form>
    </div>
  </div>
  <?php include(ROOT_PATH .'Views/common/footer.php'); ?>
<script type="text/javascript" src="/js/tag.js"></script>
</body>
</html>