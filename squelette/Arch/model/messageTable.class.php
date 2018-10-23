<?php

class messageTable extends basemodel
{

  public function getMessages()
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message";
    $res = $connection->doQueryObject( $sql, "messageTable"  );
    return (is_array($res))?res:false;
  }
  public function getMessagesSentTo($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.message where id='".$id."'" ;
    $res = $connection->doQueryObject( $sql, "message" );
    return ($res===false)?false:$res;
  }

}
