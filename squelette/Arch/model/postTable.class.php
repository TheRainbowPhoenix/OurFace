<?php

class postTable
{

/**
 * get Post By Id
 * @param  id $id id
 * @return post     post
 */
  public function getPostById($id)
  {
    $connection = new dbconnection() ;
    $sql = "select * from fredouil.post where id='".$id."'" ;
    $res = $connection->doQueryObject( $sql, "post" );
    return ($res==false)?false:$res;
  }

}
