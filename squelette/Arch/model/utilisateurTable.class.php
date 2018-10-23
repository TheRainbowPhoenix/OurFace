<?php

class utilisateurTable
{
  public static function getUserByLoginAndPass($login,$pass)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.utilisateur where identifiant='".$login."' and pass='".sha1($pass)."'" ;

    $res = $connection->doQuery( $sql );

    if($res === false)
      return false ;

    return $res ;
  }

  public static function prepare($raw) {
    if (ctype_digit($raw)){
      $raw = intval($raw);
    } else {
      $raw = str_replace('\'','', $raw);
      $raw = trim($raw);
      $raw = htmlspecialchars($raw);
    }
    return $raw;
  }

  public static function getUserById($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.utilisateur where id='".$id."'" ;
    $res = $connection->doQuery( $sql );
    return ($res===false)?false:$res;
  }

  public static function getUsers()
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.utilisateur" ;
    $res = $connection->doQuery( $sql );
    if($res === FALSE || is_null($res)) return false;
    foreach ($res as $user) {
      $users[] = new utilisateur($user);
    }
    return $users;
  }

  public static function getUsersCount($cnt)
  {
    if (!is_numeric($cnt)) {
      return false;
    }
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.utilisateur LIMIT ".$cnt."" ;
    $res = $connection->doQuery( $sql );
    if($res === FALSE || is_null($res)) return $res;
    foreach ($res as $user) {
      $users[] = new utilisateur($user);
    }
    return $users;
  }
}
