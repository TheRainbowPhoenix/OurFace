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
  }

  public static function getUsers()
  {
  }
}
