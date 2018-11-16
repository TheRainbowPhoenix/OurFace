<?php

class chatTable
{
  /**
   * get Chats
   * @return chatTable NYAAAH
   */
  public function getChats()
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.chat";
    $res = $connection->doQueryObject( $sql, "chatTable"  );
    return ($res==false)?$res:false;
  }

  /**
   * get Last Chat
   * @return int last chat
   */
  public function getLastChat()
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.chat order by id desc limit 1";
    $res = $connection->doQueryObject( $sql, "chat"  );
    return ($res==false)?$res:false;
  }
}
