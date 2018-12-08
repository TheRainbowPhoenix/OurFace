<?php
# @Author: uapv1701795
# @Date:   2018-11-17T21:25:56+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-26T16:00:40+01:00




class messageTable
{

/**
 * get Messages
 * @return messageTable message Table
 */
  public function getMessages($new=false)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message order by id desc";
    $res = $connection->doQueryObject( $sql, "message"  );
    return (is_array($res))?$res:false;
  }

  public function getMessagesLimit()
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message order by id desc limit 10";
    $res = $connection->doQueryObject( $sql, "message"  );
    return (is_array($res))?$res:false;
  }

  public function getMessagesByPage($debut, $fin, $id) {
    $connection = new dbconnection() ;
    $sql = (isset($id) && is_numeric($id))?"select * from fredouil.message where destinataire='".$id."' order by id desc limit '.$fin-$debut. offset ".$debut:"select * from fredouil.message order by id desc limit '.$fin-$debut. offset ".$debut ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
}

  /**
   * get Messages Sent To
   * @param  id $id id
   * @return message     message
   */
  public function getMessagesSentTo($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message where destinataire=".$id." order by id" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

  public function getMessagesReply($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message where parent=".$id." and post !=".$id." order by id" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

  public function getMessagesChilds($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message where parent=".$id." order by id" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }
  public function getMessagesRepost($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message where parent=".$id." and post =".$id." order by id" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

  public function getMessagesOnProfile($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message where destinataire='".$id."' or emetteur='".$id."' order by id desc limit 10" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

  public function getMessagesByID($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message where id='".$id."'" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

  public function getNewMessagesFrom($id) {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message where id>'".$id."'" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

  public static function getMessagesOnProfileSinceId($id, $em, $new=false) {
    $connection = new dbconnection() ;
    if(!is_numeric($id) || $id<0) $id=0;
      if($em<0) $sql = "select * from fredouil.message where id ".(($new)?">":"<")." ".$id." order by id desc limit 10" ;
      else $sql = "select * from fredouil.message where id ".(($new)?">":"<")." ".$id." and (emetteur=".$em." or destinataire=".$em.") order by id desc limit 10" ;
      $res = $connection->doQueryObject( $sql, "message" );
      if($res === FALSE || is_null($res)) return false;
      return $res;
  }

  public static function getMessagesSinceId($id, $em, $new=false)
  {
    $connection = new dbconnection() ;
    if(!is_numeric($id) || $id<0) $id=0;
    //select * from (select * from fredouil.message where id > 100 order by id limit 10) as x order by id desc;
    // TODO: >= to > (>= is for tests)
    if($em<0) $sql = " select * from fredouil.message where id ".(($new)?">":"<")." ".$id." order by id desc limit 10" ;
    else $sql = " select * from fredouil.message where id ".(($new)?">":"<")." ".$id." and emetteur =".$em." order by id desc limit 10" ;
    $res = $connection->doQueryObject( $sql, "message" );
    if($res === FALSE || is_null($res)) return false;
    return $res;
  }

  public function getLastCreatedMessagesId() {
    $connection = new dbconnection() ;
    $sql = "select last_value from fredouil.message_id_seq" ;
    $res = $connection->doQuery( $sql );
    return ($res==false)?false:$res;
  }

  public function getMessagesfrom($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message where emetteur='".$id."' order by id desc limit 10" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

  public function likeMessage($id, $likes)
  {
    $connection = new dbconnection() ;
    $sql = "UPDATE fredouil.message set aime=".$likes." where id='".$id."'";
    $res = $connection->doQuery( $sql );
    return $res;
  }

}
