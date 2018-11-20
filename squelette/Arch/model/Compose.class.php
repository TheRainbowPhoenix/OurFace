<?php
# @Author: uapv1701795
# @Date:   2018-11-17T22:40:31+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-20T13:50:31+01:00




class Compose implements JsonSerializable {

    public function __construct($f, $s, $t=null) {
      $this->first = $f;
      $this->second = $s;
      $this->third = $t;
    }

    public function __get($key) {
      if ($this->first->$key) {
         return $this->first->$key;
      } elseif ($this->second[0]->$key) {
        return $this->second[0]->$key;
      } elseif (isset($this->third) && $this->third[0]->$key) {
        return $this->third[0]->key;
      }else {
        return NULL;
      }
    }

    public function jsonSerialize() {
      if($this->second==false) {
          $fu = array('aime' => 0, 'parent' => 0);
          $this->second = array("0" => $fu);
      }
      if(is_array($this->second) && array_key_exists('aime', $this->second) && is_null($this->second[0]['aime'])) $this->second[0]['aime']=0;
      $jf = json_encode($this->first);
      $js = json_encode($this->second[0]);
      //echo $js;
      if (is_null($js) || $js=='null') $js = '{}';
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
