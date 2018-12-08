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

  public function getMostActive() {
    $connection = new dbconnection() ;
    $sql = "select emetteur from fredouil.chat group by emetteur order by count(*) desc limit 3";
    $res = $connection->doQuery( $sql );
    return ($res);
  }

  public function getChatLimit() {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.chat order by id desc limit 5";
    $res = $connection->doQueryObject( $sql, "chat"  );
    return (is_array($res))?$res:false;
  }

  public function getNewChatMessage($id) {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.chat where id>".$id." order by id desc limit 5;";
    $res = $connection->doQueryObject( $sql, "chat"  );
    return ($res);
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
