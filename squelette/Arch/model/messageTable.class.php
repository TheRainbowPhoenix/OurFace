<?php
# @Author: uapv1701795
# @Date:   2018-11-17T21:25:56+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-20T14:16:39+01:00




class messageTable
{

/**
 * get Messages
 * @return messageTable message Table
 */
  public function getMessages()
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message order by id desc";
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
    $sql = "select * from fredouil.message where destinataire='".$id."' order by id" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

  public function getMessagesfrom($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message where emetteur='".$id."' order by id limit 10" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

}
