<?php

define ('HOST', 'localhost') ;
define ('USER', 'uapv1701795'  ) ;
define ('PASS', '4hp6jc' ) ;
define ('DB', 'etd' ) ;

class dbconnection
{
  private $link, $error ;

  public function __construct()
  {
    $this->link = null;
    $this->error = null;
    try{
      $this->link = new PDO('pgsql:host='.HOST.';dbname='.DB, USER, PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
       // ici on crée une insance de l''objet PDO pour établir une connexion avec la base de données
       // cette nouvelle instnace sera assigné à $this->link
    }catch( PDOException $e ){
        $this->error =  $e->getMessage();
    }
  }

  public function getLastInsertId($att)
  {
    return $this->link->lastInsertId($att."_id_seq");
  }

  public function doExec( $sql )
  {
    $prepared = $this->link->prepare( $sql );
    return $prepared->execute();
  }

  public function doRawExec( $sql )
  {
    return $this->link->exec( $sql );
  }

  public function getNotify($time)
  {
    return $this->link->pgsqlGetNotify(PDO::FETCH_ASSOC, ($time>10)?$time:30000);
  }

  public function doQuery( $sql )
  {
    $prepared = $this->link->prepare( $sql );
    $prepared->execute();
    $res = $prepared->fetchAll( PDO::FETCH_ASSOC );

    return $res;
  }

  public function doQueryObject( $sql, $className )
  {
    $prepared = $this->link->prepare( $sql );
    $prepared->execute();
    $res = $prepared->fetchAll( PDO::FETCH_CLASS, $className );

    return $res;
  }

  public function __destruct()
  {
    $this->link = null;
  }
}
