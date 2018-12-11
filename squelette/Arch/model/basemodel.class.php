<?php

abstract class basemodel
{

  private $data = array();

  public function __construct($row=NULL)
  {
    if(isset($row) && is_array($row)) {
      foreach ($row as $key => $value) {
        $this->__set($value, $key);
      }
    }
  }

/**
 * [__set description]
 * @param [type] $key   [description]
 * @param [type] $value [description]
 */
  public function __set($key, $value)
  {
    $this->data[$key] = $value;
  }

/**
 * [__get description]
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
  public function __get($key)
  {
    if (array_key_exists($key, $this->data)) {
      return $this->data[$key];
    }
    return NULL;
  }

/**
 * [save description]
 * @return [type] [description]
 */
 public function save()
  {
    $connection = new dbconnection() ;

    if($this->id)
    {
      $sql = "update fredouil.".get_class($this)." set " ;

      $set = array() ;
      foreach($this->data as $att => $value)
        if($att != 'id' && $value)
          $set[] = "$att = '".$value."'" ;

      $sql .= implode(",",$set) ;
      $sql .= " where id=".$this->id ;
    }
    else
    {
      $sql = "insert into fredouil.".get_class($this)." " ;
      $sql .= "(".implode(",",array_keys($this->data)).") " ;
      $sql .= "values ('".implode("','",array_values($this->data))."')" ;
    }

    $connection->doExec($sql) ;
    $id = $connection->getLastInsertId("fredouil.".get_class($this)) ;

    /* Notify */
    $connection->exec('NOTIFY '.get_class($this));
    /* ends here */

    return $id == false ? NULL : $id ;
  }

}
