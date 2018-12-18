<?php

class postTable
{

/**
 * get Post By Id
 * @param  id $id id
 * @return post     post
 */
  public function getPostById($id, $conn=null) {
    $connection = ($conn==null)?new dbconnection():$conn;
    $sql = "select *, CASE WHEN EXISTS(select id from reported R where R.id=F.id) THEN '1' ELSE '0' END AS reported from fredouil.post F where id='".$id."'" ;
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
  public function getHashTag($tag) {
    $connection = new dbconnection() ;
    $sql = "select *, CASE WHEN EXISTS(select id from reported R where R.id=F.id) THEN '1' ELSE '0' END AS reported from fredouil.post F from fredouil.post where texte like '%#".$tag."%' order by id desc";
    $res = $connection->doQueryObject( $sql, "message" );
    return $res;
  }

}
