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
    $sql = "select * from fredouil.message";
    $res = $connection->doQueryObject( $sql, "messageTable"  );
    return (is_array($res))?$res:false;
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
