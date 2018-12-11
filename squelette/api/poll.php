<?php
session_start();
require_once '../lib/core.php';

function fetch($id = 0, $limit = 10) {
  global $db;
  $sql = "SELECT * FROM fredouil.post WHERE id > ".$id." ORDER BY id DESC LIMIT ".$limit;
  $res = $db->doQuery($sql);
  return $res;
}

function _print($value=array()) {
  header("Content-type: application/json; charset=utf-8");
  echo json_encode($value);
  exit;
}

if(array_key_exists('logged', $_SESSION) && array_key_exists('user_var', $_SESSION)
&& $_SESSION['logged']==true && array_key_exists('id', $_SESSION['user_var'])) {
  $id = $_SESSION['user_var']['id'];
  if(!is_numeric($id)) die("bad token");
  if (empty($_REQUEST['from'])) {
    $id = 0;
  } else {
    $id = (int)$_REQUEST['from'];
  }

  $db = new dbconnection();

  set_time_limit(45);
  $r = fetch($id);
  if (empty($r)) {
    $db->doRawExec('LISTEN post');
    $ret = $db->getNotify(30000);
    //$ret = post::listen();
    if($ret === false) {
      return $ret;
    }
    $r = fetch($id);
  }
  _print($r);
}


/*
class poll
{
  private static function fetch($db, $id = 0, $limit = 10) {
    return $db->doQuery("SELECT * FROM fredouil.post WHERE id > ".$id." ORDER BY id DESC LIMIT ".$limit);
  }

  public static function chat($params) {
    $db = new dbconnection();
    if (empty($params['from'])) {
      $id = 0;
    } else {
      $id = (int)$params['from'];
    }
    set_time_limit(45);
    $r = fetch($db, $id);
    if (empty($r) || strcmp($r, '[]') ==0) {
      $db->doRawExec('LISTEN post');
      $ret = $db->getNotify(30000);
      //$ret = post::listen();
      if($ret === false) {
        return $ret;
      }
      $r = fetch($db, $params['from']);
    } else {
      return $r;
    }
    return $r;
  }
}*/

 ?>
