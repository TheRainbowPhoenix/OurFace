<?php

abstract class basemodel
{

  private $data = array();

  public function __construct($tableau)
  {
    if(isset($tableau) && !is_null($tableau) && is_array($tableau)) {
      foreach ($tableau as $key => $value) {
        $this->__set($value, $key);
      }
    }
  }

  public function __set($key, $value)
  {
    $this->data[$key] = $value;
  }

  public function __get($key)
  {
    if (array_key_exists($key, $this->data)) {
      return $this->data[$key];
    }
    return NULL;
  }


 public function save()
  {
    $connection = new dbconnection() ;

    if($this->id)
    {
      $sql = "update ".get_class($this)." set " ;

      $set = array() ;
      foreach($this->data as $att => $value)
        if($att != 'id' && $value)
          $set[] = "$att = '".$value."'" ;

      $sql .= implode(",",$set) ;
      $sql .= " where id=".$this->id ;
    }
    else
    {
      $sql = "insert into ".get_class($this)." " ;
      $sql .= "(".implode(",",array_keys($this->data)).") " ;
      $sql .= "values ('".implode("','",array_values($this->data))."')" ;
    }

    $connection->doExec($sql) ;
    $id = $connection->getLastInsertId("fredouil.".get_class($this)) ;

    return $id == false ? NULL : $id ;
  }

}
