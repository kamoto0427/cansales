<?php

  /**
   * XSS対策：エスケープ処理
   * @param string $s エスケープする文字列
   * @return string 処理された文字列 
   */
  function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
  }

  /**
   * CSRF対策
   * @param void
   * @return string $csrf_token
   */
  function setToken() {
    $csrf_token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $csrf_token;
    return $csrf_token;
  }