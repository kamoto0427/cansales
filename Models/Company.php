<?php
require_once(ROOT_PATH .'/Models/Db.php');
ini_set('display_errors', "On");

class Company
{
  /**
   * ユーザ-の登録
   * @param array $userDate
   * @return bool $result
   */
  public static function createCompany($companyDate)
  {
    $result = false;
    $sql = 
    'INSERT INTO companies 
    (company_name, company_url, tel, postal_code, company_adress, email, password, role)
    VALUES (:company_name, :company_url, :tel, :postal_code, :company_adress, :email, :password, :role)';

    $company_name = $companyDate['company_name'];
    $company_url = $companyDate['company_url'];
    $company_tel = $companyDate['company_tel'];
    $company_postal = $companyDate['company_postal'];
    $company_adress = $companyDate['company_adress'];
    $company_email = $companyDate['company_email'];
    $company_pass = password_hash($companyDate['company_pass'], PASSWORD_DEFAULT);
    $role = $companyDate['role'];

    try {
      $pdo = connect();
      $pdo->beginTransaction();
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);
      $stmt->bindValue(':company_url', $company_url, PDO::PARAM_STR);
      $stmt->bindValue(':tel', $company_tel, PDO::PARAM_INT);
      $stmt->bindValue(':postal_code', $company_postal, PDO::PARAM_INT);
      $stmt->bindValue(':company_adress', $company_adress, PDO::PARAM_STR);
      $stmt->bindValue(':email', $company_email, PDO::PARAM_STR);
      $stmt->bindValue(':password', $company_pass, PDO::PARAM_STR);
      $stmt->bindValue(':role', $role, PDO::PARAM_INT);
      $result = $stmt->execute();
      $pdo->commit();
      return $result;
    } catch(\Exception $e) {
      $pdo->rollBack();
      return $result;
    }
  }

  /**
   * ログインユーザーの取得
   * @param string $id
   * @return bool $result
   */
  public function getCompanyById($id)
  {
    $sql = 'SELECT * FROM companies WHERE id = :id';
    try {
      $stmt = connect()->prepare($sql);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch(\Exception $e) {
      return $result = false;
    }
  }

    /**
   * 会社情報の編集
   * @param array $userDate
   * @return bool $result
   */
  public static function updateCompany($companyDate)
  {
    $sql = 'UPDATE companies SET
              company_name = :company_name, company_url = :company_url, tel = :tel, postal_code = :postal_code, company_adress = :company_adress, email = :email, free_text = :free_text
            WHERE 
              id = :id';

    $company_name = $companyDate['company_name'];
    $company_url = $companyDate['company_url'];
    $company_tel = $companyDate['company_tel'];
    $company_postal = $companyDate['company_postal'];
    $company_adress = $companyDate['company_adress'];
    $company_email = $companyDate['company_email'];
    $free_text = $companyDate['free_text'];
    $id = $companyDate['id'];

    try {
      $pdo = connect();
      $pdo->beginTransaction();
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':company_name', $company_name, PDO::PARAM_STR);
      $stmt->bindValue(':company_url', $company_url, PDO::PARAM_STR);
      $stmt->bindValue(':tel', $company_tel, PDO::PARAM_INT);
      $stmt->bindValue(':postal_code', $company_postal, PDO::PARAM_INT);
      $stmt->bindValue(':company_adress', $company_adress, PDO::PARAM_STR);
      $stmt->bindValue(':email', $company_email, PDO::PARAM_STR);
      $stmt->bindValue(':free_text', $free_text, PDO::PARAM_STR);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $result = $stmt->execute();
      $pdo->commit();
      return $result;
    } catch(\Exception $e) {
      $pdo->rollBack();
      return $result = false;
    }
  }

  /**
   * ログイン処理
   * @param string $email
   * @param string $password
   * @return bool $result
   */
  public static function login($email, $password)
  {
    $result = false;
    // 会社をemailで検索
    $company = self::getCompanyByEmail($email);
    if(!$company) {
      $_SESSION['msg'] = 'メールアドレスまたはパスワードが一致しません。';
      return $result;
    }

    // パスワードの照会
    if(password_verify($password, $company['password'])) {
      session_regenerate_id(true);
      $_SESSION['login_company'] = $company;
      $result = true;
      return $result;
    } else {
      $_SESSION['msg'] = 'メールアドレスまたはパスワードが一致しません。';
      return $result;
    }
  }

  /**
   * ログイン処理
   * @param string $email
   * @return array|bool $company|false
   */
  public static function getCompanyByEmail($email)
  {
    $sql = 'SELECT * FROM companies WHERE email = :email';

    try {
      $stmt = connect()->prepare($sql);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->execute();
      $company = $stmt->fetch();
      return $company;
    } catch(\Exception $e) {
      return false;
    }
  }

  /**
   * ログインチェック
   * @param void
   * @return bool $result
   */
  public function checkLogin()
  {
    $result = false;
    if(isset($_SESSION['login_company']) && $_SESSION['login_company']['id'] > 0 ) {
      return $result = true;
    }
    return $result;
  }
}
