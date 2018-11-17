<?php

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
    $sql = "select * from fredouil.message where destinataire='".$id."' order by id limit 10" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

}
