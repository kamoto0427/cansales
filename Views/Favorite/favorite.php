<?php
session_start();
require_once(ROOT_PATH .'/Models/Favorite.php');

$obj_f = new Favorite();


if(isset($_POST)) {
  $c_id = $_SESSION['login_company']['id'];
  $p_id = $_POST['post_id'];

  if($obj_f->check_favolite_duplicate($c_id,$p_id)) {
    $result_d = $obj_f->favoriteCancal($c_id,$p_id);
  } else {
    $result = $obj_f->favoriteDone($c_id,$p_id);
  }
}