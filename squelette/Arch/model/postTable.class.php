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

  public function getLastPostId() {
    $connection = new dbconnection() ;
    $sql = "select MAX(id) from fredouil.post" ;
    $res = $connection->doQuery( $sql );
    return ($res==false)?false:$res;
  }
  public function getLastCreatedPostId() {
    $connection = new dbconnection() ;
    $sql = "select last_value from fredouil.post_id_seq" ;
    $res = $connection->doQuery( $sql );
    return ($res==false)?false:$res;
  }

}
