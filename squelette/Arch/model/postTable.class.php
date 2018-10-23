<?php

class postTable extends basemodel
{

  public function getPostById($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.post where id='".$id."'" ;
    $res = $connection->doQuery( $sql );
    return ($res==true)?res:NULL;
  }

}
