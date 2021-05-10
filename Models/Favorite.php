<?php

require_once(ROOT_PATH .'/Models/Db.php');
ini_set('display_errors', "On");

class favorite
{
  /** すでにお気に入りしているか判定
   * @param int $company_id
   * @param int $post_id
   * @return bool $favorite
   */

  public function check_favolite_duplicate($company_id, $post_id)
  {
    $sql = 'SELECT *
            FROM favorites
            WHERE company_id = :company_id AND post_id = :post_id';
    try {
      $stmt = connect()->prepare($sql);
      $stmt->bindValue(':company_id', $company_id, PDO::PARAM_INT);
      $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
      $stmt->execute();
      $favorite = $stmt->fetch(PDO::FETCH_ASSOC);
      return $favorite;
    } catch(\Exception $e) {
      return $favorite = false;
    }
  }

  /** お気に入り登録
   * @param int $company_id
   * @param int $post_id
   * @return bool $favorite
   */

  public function favoriteDone($company_id,$post_id)
  {
    $sql = 'INSERT INTO favorites(company_id, post_id)
            VALUES (:company_id, :post_id)';

    try {
    $pdo = connect();
    $pdo->beginTransaction();
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':company_id', $company_id, PDO::PARAM_INT);
    $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $favorite = $stmt->execute();
    $pdo->commit();
    return $favorite;
    } catch(\Exception $e) {
      $pdo->rollBack();
      return $favorite = false;
    }
  }

  /** お気に入り解除
   * @param int $company_id
   * @param int $post_id
   * @return bool $favorite
   */
  public function favoriteCancal($company_id,$post_id) 
  {
    $sql = 'DELETE FROM favorites WHERE company_id = :company_id AND post_id = :post_id';

    try {
    $pdo = connect();
    $pdo->beginTransaction();
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':company_id', (int)$company_id, PDO::PARAM_INT);
    $stmt->bindValue(':post_id', (int)$post_id, PDO::PARAM_INT);
    $favorite = $stmt->execute();
    $pdo->commit();
    return $favorite;
    } catch(\Exception $e) {
      $pdo->rollBack();
      return $favorite = false;
    }
  }

  /** マイページにてお気に入りしている投稿はお気に入り一覧で全て表示
   * @param int $company_id
   * @return bool $favorite
   */

  public function getFavoriteById($company_id)
  {
    $sql = 'SELECT f.id AS お気に入りID, f.company_id AS 企業ID, f.post_id AS リストID, p.id AS p_id, p.title, c.id AS c_id 
            FROM posts p
            INNER JOIN favorites f 
            ON f.post_id = p.id
            INNER JOIN companies c
            ON f.company_id = c.id
            WHERE f.company_id = :company_id';
    try {
      $stmt = connect()->prepare($sql);
      $stmt->bindValue(':company_id', (int)$company_id, PDO::PARAM_INT);
      $stmt->execute();
      $favorite = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $favorite;
    } catch(\Exception $e) {
      return $favorite = false;
    }
  }
}