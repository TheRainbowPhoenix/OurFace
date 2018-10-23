<?php

class chatTable
{
  public function getChats()
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.chat";
    $res = $connection->doQueryObject( $sql, "chatTable"  );
    return ($res==false)?$res:false;
  }

  public function getLastChat()
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.chat order by id desc limit 1";
    $res = $connection->doQueryObject( $sql, "chat"  );
    return ($res==false)?$res:false;
  }
}
