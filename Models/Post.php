<?php
require_once(ROOT_PATH .'/Models/Db.php');
ini_set('display_errors', "On");

class Post
{
  /**
   * リストの一覧取得
   * @param array $result
   * @return bool $result
   */
  public function getAllList()
  {
    $sql = 'SELECT *
            FROM companies c 
            INNER JOIN posts p
            ON p.company_id = c.id';

    try {
      $stmt = connect()->query($sql);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(\Exception $e) {
      return $result = false;
    }
  }

  /**
   * リストの詳細を取得
   * @param int $id
   * @return bool $result
   */
  public function getShowList($id)
  {
    $sql = 'SELECT *
            FROM companies c 
            INNER JOIN posts p
            ON p.company_id = c.id
            WHERE p.id = :id';
    try {
      $stmt = connect()->prepare($sql);
      $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch(\Exception $e) {
      return $result = false;
    }
  }

  /** カテゴリーIDからカテゴリー名に変換
   * @param int $category_id
   * @return string
   */

  public function setCategoryName($category)
  {
    if($category === '1') {
      return '求人';
    } elseif($category === '2') {
      return '人材育成・研修';
    } elseif($category === '3') {
      return '集客・マーケティング';
    } elseif($category === '4') {
      return 'Webサイト制作';
    } elseif($category === '5') {
      return 'Webコンテンツ制作';
    } elseif($category === '6') {
      return 'イラスト';
    } elseif($category === '7') {
      return '営業・コールセンター代行';
    } elseif($category === '8') {
      return 'ビジネス相談・経営コンサル';
    } elseif($category === '9') {
      return '士業(税理士・行政書士など)';
    } elseif($category === '10') {
      return '翻訳・語学';
    } elseif($category === '11') {
      return 'クリーニング';
    } elseif($category === '12') {
      return '音楽・ナレーション';
    } elseif($category === '13') {
      return 'その他';
    } elseif($category === '0') {
      return 'カテゴリーを選択してください。';
    }
  }

  /**
   * リストの投稿をDBに保存
   * @param int    $company_id
   * @param array $postDate
   * @param string $save_path
   * @param string $j_tags
   * @return bool $result
   */

  public function createList($company_id,$postDate,$save_path, $j_tags)
  {
    $result = false;

    $sql = 'INSERT INTO posts (company_id, title, text, category_id, price, img, tag)
            VALUES (:company_id, :title, :text, :category_id, :price, :img, :tag)';

    $title = $postDate['title'];
    $text = $postDate['text'];
    $category = $postDate['category'];
    $price = $postDate['price'];


    try {
      $pdo = connect();
      $pdo->beginTransaction();
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':company_id', (int)$company_id, PDO::PARAM_INT);
      $stmt->bindValue(':title', $title, PDO::PARAM_STR);
      $stmt->bindValue(':text', $text, PDO::PARAM_STR);
      $stmt->bindValue(':category_id', (int)$category, PDO::PARAM_INT);
      $stmt->bindValue(':price', (int)$price, PDO::PARAM_INT);
      $stmt->bindValue(':img', $save_path, PDO::PARAM_STR);
      $stmt->bindValue(':tag', $j_tags, PDO::PARAM_STR);
      $stmt->execute();
      $pdo->commit();
      return $result;
    } catch(\Exception $e) {
      $pdo->rollBack();
      return $result;
    }
  }

    /**
   * リストの編集
   * @param int    $id
   * @param array $postDate
   * @param string $save_path
   * @param string $j_tags
   * @return bool $result
   */
  public function updateList($id, $postDate, $save_path, $j_tags)
  {
    $result = false;

    $sql = 'UPDATE posts SET
              title = :title, text = :text, category_id = :category_id, price = :price, img = :img, tag = :tag
            WHERE
              id = :id';
    
    $title = $postDate['title'];
    $text = $postDate['text'];
    $category = $postDate['category'];
    $price = $postDate['price'];

    try {
      $pdo = connect();
      $pdo->beginTransaction();
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':title', $title, PDO::PARAM_STR);
      $stmt->bindValue(':text', $text, PDO::PARAM_STR);
      $stmt->bindValue(':category_id', $category, PDO::PARAM_INT);
      $stmt->bindValue(':price', $price, PDO::PARAM_INT);
      $stmt->bindValue(':img', $save_path, PDO::PARAM_STR);
      $stmt->bindValue(':tag', $j_tags, PDO::PARAM_STR);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $result = $stmt->execute();
      $pdo->commit();
      return $result;
    } catch(\Exception $e) {
      $pdo->rollBack();
      return $result;
    }
  }

  /**
   * リストの削除
   * @param int $id
   * @return bool $result
   */
  public function deleteList($id)
  {
    $sql = 'DELETE FROM posts WHERE id = :id';

    try {
      $pdo = connect();
      $pdo->beginTransaction();
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
      $result = $stmt->execute();
      $pdo->commit();
      return $result;
    } catch(\Exception $e) {
      $pdo->rollBack();
      return $result = false;
    }
  }

  /** リストの検索
   * @param string $search
   * @return bool $result
   */
  public function listSerach($search)
  {
    $sql = " SELECT * FROM posts WHERE title LIKE '%" . $search . "%' ";
    try {
      $stmt = connect()->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(\Exception $e) {
      return $result = false;
    }
  }

  /** カテゴリーごとの表示
   * @param int $id
   * @return bool $result
   */
  public function GetCategoryViewById($id)
  {
    $sql = 'SELECT c.id AS 企業ID, c.company_name AS 企業名, p.id AS リストID, p.company_id, p.title, p.category_id, p.tag, p.text, p.price, p.created_at
            FROM posts p
            INNER JOIN companies c ON c.id = p.company_id
            WHERE p.category_id = :category_id';
    try {
      $stmt = connect()->prepare($sql);
      $stmt->bindValue(':category_id', (int)$id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(\Exeception $e) {
      return $result = false;
    }
  }

    /**
   * マイページにて投稿したリストを全て表示
   * @param int $id
   * @return bool $result
   */
  public function getListMyShow($id)
  {
    $sql = 'SELECT p.id AS リストID, p.company_id, p.title, p.text, p.category_id, p.price, p.created_at, p.tag, c.id AS 企業ID, c.company_name
            FROM posts p
            INNER JOIN companies c
            ON p.company_id = c.id
            WHERE c.id = :id';
    try {
      $stmt = connect()->prepare($sql);
      $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(\Exeception $e) {
      return $result = false;
    }
  }

  /**
   * マイページにてリクエストしたリスト一覧を取得
   * @param int   $id
   * @return bool $result
   */
  public function getRequestMyShow($id)
  {
    $sql = 'SELECT  r.id AS リクエストID, r.company_id AS 企業ID, r.post_id AS リストID, r.text AS リクエストテキスト, r.created_at AS 最新のリクエスト送信日, c.id AS 企業ID, c.company_name, p.id AS リストID, p.title, p.category_id, p.price, p.tag
            FROM  comments r 
            INNER JOIN companies c ON r.company_id = c.id 
            INNER JOIN posts p ON r.post_id = p.id 
            WHERE not exists(
                  select 1 from comments 
                  where company_id = r.company_id 
                    and post_id = r.post_id 
                    and created_at > r.created_at
                )
            and r.company_id = :id';
    try {
      $stmt = connect()->prepare($sql);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchall(PDO::FETCH_ASSOC);
      return $result;
    } catch(\Exeception $e) {
      return $result = false;
    }
  }
}