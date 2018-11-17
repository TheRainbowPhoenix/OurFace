<?php

class Compose implements JsonSerializable {

    public function __construct($f, $s, $t=null) {
      $this->first = $f;
      $this->second = $s;
      $this->third = $t;
    }

    public function __get($key) {
      if ($this->$first->$key) {
         return $this->$first->$key;
      } elseif ($this->$second[0]->$key) {
        return $this->$second[0]->$key;
      } elseif (isset($this->third) && $this->$third[0]->$key) {
        return $this->$third[0]->$key;
      }else {
        return NULL;
      }
    }

    public function jsonSerialize() {
      $jf = json_encode($this->first);
      $js = json_encode($this->second[0]);
      if (isset($this->third)) {
        $jt = json_encode($this->third[0]);
        $r = array_merge((array)json_decode($jf, true, JSON_UNESCAPED_SLASHES),json_decode($js, true, JSON_UNESCAPED_SLASHES),json_decode($jt, true, JSON_UNESCAPED_SLASHES));
      } else {
        $r = array_merge(json_decode($jf, true, JSON_UNESCAPED_SLASHES),json_decode($js, true, JSON_UNESCAPED_SLASHES));
      }
      return $r;
    }
}

 ?>
