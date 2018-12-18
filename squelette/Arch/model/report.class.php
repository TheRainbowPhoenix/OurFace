<?php

class report {
  private static function rep($uid, $reason) {
    $connection = new dbconnection();
    $sql = "INSERT INTO reported (id, message, possibly_sensitive) SELECT '".$uid."', '".$reason."', True WHERE NOT EXISTS (SELECT 1 FROM reported WHERE id ='".$uid."')";
    $res = $connection->doQuery($sql);
    var_dump($res);
    return $res;
  }

  public function messageID($id)
  {
    $connection = new dbconnection() ;
    $sql = "select post, CASE WHEN EXISTS(select id from verified V where V.id=F.emetteur) THEN '1' ELSE '0' END AS verified from fredouil.message F where id='".$id."'" ;
    $res = $connection->doQuery( $sql);
    if(is_array($res) && array_key_exists(0, $res) && $res[0]['verified'] !="1") {
      return report::rep($res[0]['post'], 'possibly explicit content');
    }
    return $res;
  }

  public function chatID($id)
  {
    $connection = new dbconnection() ;
    $sql = "select post, CASE WHEN EXISTS(select id from verified V where V.id=F.emetteur) THEN '1' ELSE '0' END AS verified from fredouil.chat F where id='".$id."'" ;
    $res = $connection->doQuery( $sql);
    if(is_array($res) && array_key_exists(0, $res) && $res[0]['verified'] !="1") {
      return report::rep($res[0]['post'], 'possibly explicit content');
    }
    return $res;
  }
}
