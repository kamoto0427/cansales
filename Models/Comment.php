<?php
require_once(ROOT_PATH .'/Models/Db.php');
ini_set('display_errors', "On");

class Comment
{
  /**　コメントをDBに登録
   * @param string $msg
   * @param int    $company_id
   * @param int    $post_id
   * @return bool $result
   */
  public function commentInsert($msg, $company_id, $post_id)
  {
    $sql = 'INSERT INTO comments (company_id, post_id, text) VALUES (:company_id, :post_id, :text)';
    try {
      $pdo = connect();
      $pdo->beginTransaction();
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':company_id', $company_id, PDO::PARAM_INT);
      $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
      $stmt->bindValue(':text', $msg, PDO::PARAM_STR);
      $result = $stmt->execute();
      $pdo->commit();
      return $result;
    } catch(\Exception $e) {
      $pdo->rollBack();
      echo $e->getMessage();
      return $result = false;
    }
  }

  /** 投稿に紐づいたコメントIDを取得し、リクエストページにコメントを全て表示
   * @param int $post_id
   * @return bool $result
   */

  public function GetCommentById($post_id)
  {
    $sql = 'SELECT c.id, c.company_name, co.id, co.company_id, co.post_id, co.text, co.created_at
            FROM companies c
            INNER JOIN comments co
            ON co.company_id = c.id
            WHERE post_id = :post_id
            ORDER BY created_at ASC';
    
    try {
      $stmt = connect()->prepare($sql);
      $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch(\Exception $e) {
      return $result = false;
    }
  }

  /** コメントの削除
   * @param int $id
   * @return bool $result
   */
  public function CommentDelete($id)
  {
    $sql = 'DELETE FROM comments WHERE id = :id';

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
} 