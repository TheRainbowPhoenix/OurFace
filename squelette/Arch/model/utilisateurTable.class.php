<?php
# @Author: uapv1701795
# @Date:   2018-11-17T21:25:56+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-20T15:36:26+01:00




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

/**
 * prepare
 * @param  param $raw this fish is so raw !
 * @return fish      cooked fish
 */
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

/**
 * get User By Id
 * @param  id $id id
 * @return user     user
 */
  public static function getUserById($id, $conn=null) {
    $connection = ($conn==null)?new dbconnection():$conn;
    $sql = "select *, CASE WHEN EXISTS(select id from verified V where V.id=F.id) THEN '1' ELSE '0' END AS verified from fredouil.utilisateur F where id='".$id."'" ;
    $res = $connection->doQueryObject( $sql, "utilisateur" ); 
    return ($res===false)?false:$res;
  }

  public static function alter($type, $id, $img) {
    if(!is_numeric($id) || $id<=0) return false;
    $connection = new dbconnection();
    $sql = "UPDATE fredouil.utilisateur set ".$type."='".$img."' where id='".$id."'";
    $res = $connection->doQuery($sql);
    return $res;
  }

/**
 * get Users, yes all
 * @return array utilisateur
 */
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
/**
 * get Users, yes all
 * @return array utilisateur
 */
  public static function getUsersV2()
  {
    $connection = new dbconnection() ;
    $sql = "select *, CASE WHEN EXISTS(select id from verified V where V.id=F.id) THEN '1' ELSE '0' END AS verified from fredouil.utilisateur F" ;
    $res = $connection->doQueryObject( $sql, "utilisateur" );
    if($res === FALSE || is_null($res)) return false;

    return $res;
  }

  public static function getUsersFrom($id)
  {
    $connection = new dbconnection() ;
    if(!is_numeric($id) || $id<0) $id=0;
    $sql = " select *, CASE WHEN EXISTS(select id from verified V where V.id=F.id) THEN '1' ELSE '0' END AS verified from fredouil.utilisateur F where id between ".$id." and ".($id+18)." order by id" ;
    $res = $connection->doQueryObject( $sql, "utilisateur" );
    if($res === FALSE || is_null($res)) return false;
    return $res;
  }

  public static function userHasName($name) {
    $connection = new dbconnection() ;
    $sql = "select id from fredouil.utilisateur where identifiant like '".$name."'";
    $res = $connection->doQuery( $sql );

    if($res === false)
      return -1 ;
    return $res[0]['id'];
  }

  public static function getRandomUsers()
  {
    $connection = new dbconnection() ;
    $sql = "select *, CASE WHEN EXISTS(select id from verified V where V.id=F.id) THEN '1' ELSE '0' END AS verified from fredouil.utilisateur F ORDER BY RANDOM() LIMIT 3;" ;
    //$sql = "select * from fredouil.utilisateur ORDER BY RANDOM() LIMIT 3" ;
    $res = $connection->doQueryObject( $sql, "utilisateur" );
    //var_dump($res);
    if($res === FALSE || is_null($res)) return false;

    return $res;
  }

/**
 * get Users Count
 * @param  numeric $cnt count
 * @return array      utilisateur
 */
  public static function getUsersCount($cnt)
  {
    if (!is_numeric($cnt) || $cnt<=0) {
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
